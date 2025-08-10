<?php
namespace App\Models;
use Support\Vault\Sanctum\Model;

class Room extends Model {

    protected string $table = 'rooms';

    protected array $fillable = [
        'house',
        'number',
        'unique_id',
    ];

    public function __construct()
    {
        $this->unique_id = self::generateUuid();
    }

}