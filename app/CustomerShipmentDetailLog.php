<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerShipmentDetailLog extends Model
{
    protected $connection = "sqlsrv_lts";
    protected $auditTimestamps = true;
}
