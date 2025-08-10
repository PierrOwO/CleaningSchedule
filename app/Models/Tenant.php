<?php
namespace App\Models;
use Support\Vault\Sanctum\Model;

class Tenant extends Model {

    protected string $table = 'tenants';

    protected array $fillable = [
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