<?php
namespace App\Models;

use Support\Vault\Sanctum\Model;

class CleaningOverride extends Model {

    protected string $table = 'cleaning_overrides';

    protected array $fillable = [
        'house',
        'room',
        'tenant',
        'week',
        'year',
    ];

}