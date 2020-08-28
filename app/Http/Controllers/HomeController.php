<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{
    // public function __construct() {
    //     $this->middleware('auth:api');
    // }

    public function index()
    {
        dd(auth()->user());
    }
}
