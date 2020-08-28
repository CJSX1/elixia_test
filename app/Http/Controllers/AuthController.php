<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use App\User;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class AuthController extends Controller {

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            if (! $token = \JWTAuth::attempt($validator->validated())) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (\JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }


        $storeToken = array ('access_token' => $token);
        DB::table('users')->update($storeToken);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL(),
        ]);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile() {
        return response()->json(auth()->user());
    }

    public function dashboard( $token )
    {
        try {
            if( Auth::user()->id ){
                return view('dashboard');
            } else {
                return redirect('/');
            }
        } catch(Exception $e){
            return response()->json([ 'status' => '400', 'message' => 'Operation failed!', ]);
        }
    }

    public function getDispatchItems( $limit ){
        try {
            if( Auth::user()->id ){
                $ini_dispatch_limit = 0;
                $dispatch = DB::select('call get_dispatchDetails('.$limit.')'); 
        
                $limit = $limit + 10;
                    
                return response()->json([ 'items' => $dispatch, 'limit' => $limit ]);
            }
        } catch(Exception $e){
            return response()->json([ 'status' => '400', 'message' => 'Operation failed!', ]);
        }
    }

    public function addDispatchPage( $token )
    {
       try {
            if( Auth::user()->id ){
                $sourceCodes = DB::table('source_masters')->get();
                $destinationCodes = DB::table('destination_masters')->get();
                $transporterCodes = DB::table('transporter_masters')->get();
                return view('addDispatchPage',compact('sourceCodes','destinationCodes','transporterCodes'));
            } else {
                return redirect('/');
            }
        } catch(Exception $e){
            return response()->json([ 'status' => '400', 'message' => 'Operation failed!', ]);
        }
    }

    public function saveDispatch(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'delivery_no' => 'required | unique:dispatches',
                'source_code' => 'required',
                'dest_code' => 'required',
                'trans_code' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'veh_no' => ['required','regex:^[A-Z]{2}[0-9]{1,2}(?:[A-Z])?(?:[A-Z]*)?[0-9]{4}$^'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $req_data = $request->all();

            $dispatch = DB::select( 
                'call insert_dispatchDetails( '.$req_data['ship_no'].', '.$req_data['delivery_no'].', '.$req_data['source_code'].', '.$req_data['dest_code'].', "'.$req_data['veh_no'].'", '.$req_data['trans_code'].', "'.$req_data['start_date'].'", "'.$req_data['end_date'].'", "'.$req_data['driver_nm'].'", '.$req_data['driver_ph'].', '.Auth::user()->id.', '.Auth::user()->id.')' );

            return response()->json(['status' => 200, 'message' => 'Inserted successfully!']);

        } catch(Exception $e){
            return response()->json([ 'status' => '400', 'message' => 'Operation failed!', ]);
        }
    }

    public function searchDispatch( $search )
    {
        if ($search && !empty($search))
        {
            $result = DB::table('dispatches as d')
                        ->join('source_masters as sm','d.source_code','sm.id' )
                        ->join('destination_masters as dm','d.dest_code','dm.id' )
                        ->join('transporter_masters as tm','d.trans_code','tm.id' )
                        ->select('d.*','sm.sourceName','dm.destName','tm.transName')
                        ->where('d.isDeleted',0)
                        ->where('sm.sourceName', 'LIKE', "%{$search}%")
                        ->orWhere('dm.destName', 'LIKE', "%{$search}%")
                        ->orWhere('tm.transName', 'LIKE', "%{$search}%")
                        ->orWhere('d.vehicle_no', 'LIKE', "%{$search}%")
                        ->orderBy('d.id','Desc')
                        ->get();
    
            return response()->json([ 'items' => $result ]);
        } 
    }

    public function sortDispatch( $sort )
    {
        if ($sort && !empty($sort))
        {
            if( $sort == 1 ){
                $result = DB::table('dispatches as d')
                            ->join('source_masters as sm','d.source_code','sm.id' )
                            ->join('destination_masters as dm','d.dest_code','dm.id' )
                            ->join('transporter_masters as tm','d.trans_code','tm.id' )
                            ->select('d.*','sm.sourceName','dm.destName','tm.transName')
                            ->where('d.isDeleted',0)
                            ->orderBy('d.start_date','Asc')
                            ->get();
        
                return response()->json([ 'items' => $result ]);
            } else if( $sort == 2 ){
                $result = DB::table('dispatches as d')
                            ->join('source_masters as sm','d.source_code','sm.id' )
                            ->join('destination_masters as dm','d.dest_code','dm.id' )
                            ->join('transporter_masters as tm','d.trans_code','tm.id' )
                            ->select('d.*','sm.sourceName','dm.destName','tm.transName')
                            ->where('d.isDeleted',0)
                            ->orderBy('d.end_date','Asc')
                            ->get();
        
                return response()->json([ 'items' => $result ]);
            } else if( $sort == 3 ){
                $result = DB::table('dispatches as d')
                            ->join('source_masters as sm','d.source_code','sm.id' )
                            ->join('destination_masters as dm','d.dest_code','dm.id' )
                            ->join('transporter_masters as tm','d.trans_code','tm.id' )
                            ->select('d.*','sm.sourceName','dm.destName','tm.transName')
                            ->where('d.isDeleted',0)
                            ->orderBy('sm.sourceName','Asc')
                            ->get();
        
                return response()->json([ 'items' => $result ]);
            } else {
                $result = DB::table('dispatches as d')
                            ->join('source_masters as sm','d.source_code','sm.id' )
                            ->join('destination_masters as dm','d.dest_code','dm.id' )
                            ->join('transporter_masters as tm','d.trans_code','tm.id' )
                            ->select('d.*','sm.sourceName','dm.destName','tm.transName')
                            ->where('d.isDeleted',0)
                            ->orderBy('d.id','Asc')
                            ->get();
        
                return response()->json([ 'items' => $result ]);
            }
        }
    }

    public function fileExport( $token ) 
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }  
}