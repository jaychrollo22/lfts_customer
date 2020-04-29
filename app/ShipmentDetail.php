<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    protected $connection = "sqlsrv";
    protected $auditTimestamps = true;
}
