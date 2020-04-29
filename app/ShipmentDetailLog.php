<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetailLog extends Model
{
    protected $connection = "sqlsrv";
    protected $auditTimestamps = true;
}
