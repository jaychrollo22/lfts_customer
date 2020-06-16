<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDoDetail extends Model
{
    protected $connection = "sqlsrv_lts";
    protected $auditTimestamps = true;
}
