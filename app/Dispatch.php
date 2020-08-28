<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    protected $table = 'dispatches';

    protected $fillable = [
        'delivery_no',
        'source_code',
        'dest_code',
        'vehicle_no',
        'trans_code',
        'start_date',
        'end_date',
        'driver_name',
        'driver_phone',
        'created_by',
        'updated_by',
    ];
}
