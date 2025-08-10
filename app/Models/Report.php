<?php
namespace App\Models;
use Support\Vault\Sanctum\Model;

class Report extends Model {

    protected static $table = 'reports';

    protected static $fillable = [
        'name',
        'status'
    ];
}