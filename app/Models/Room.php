<?php
namespace App\Models;
use Support\Vault\Sanctum\Model;

class Room extends Model {

    protected static $table = 'rooms';

    protected static $fillable = [
        'house',
        'number',
        'type',
        'unique_id',
    ];

    public function __construct()
    {
        $this->unique_id = self::generateUuid();
    }

}