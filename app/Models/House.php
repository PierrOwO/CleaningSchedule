<?php
namespace App\Models;

use Support\Vault\Sanctum\Model;

class House extends Model {

    protected static $table = 'houses';

    protected static $fillable = [
        'name',
        'address',
        'unique_id',
        'founder',
        'slug',
    ];

    public function __construct()
    {
        $this->unique_id = self::generateUuid();
    }



}