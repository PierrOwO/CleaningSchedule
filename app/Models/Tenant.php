<?php
namespace App\Models;
use Support\Vault\Sanctum\Model;

class Tenant extends Model {

    protected static $table = 'tenants';

    protected static $fillable = [
        'room',
        'user',
        'status',
        'unique_id',
    ];

    public function __construct()
    {
        $this->unique_id = self::generateUuid();
    }

}