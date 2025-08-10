<?php
namespace App\Models;

use Support\Vault\Sanctum\Model;

class House extends Model {

    protected static $table = 'houses';

    protected array $fillable = [
        'name',
        'address',
        'unique_id',
    ];

    public function __construct()
    {
        $this->unique_id = self::generateUuid();
    }



}