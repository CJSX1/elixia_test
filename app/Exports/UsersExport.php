<?php

namespace App\Exports;

use App\Dispatch;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('dispatches as d')
                    ->join('source_masters as sm','d.source_code','sm.id')
                    ->join('destination_masters as dm','d.dest_code','dm.id')
                    ->join('transporter_masters as tm','d.trans_code','tm.id')
                    ->select('d.delivery_no','d.shipment_no','sm.sourceName','dm.destName','d.vehicle_no','tm.transName','d.start_date','d.end_date','d.driver_name','d.driver_phone')
                    ->where('d.isDeleted',0)
                    ->get();
    }
}
