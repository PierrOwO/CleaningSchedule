<?php
namespace App\Models;

use Support\Vault\Sanctum\Model;

class CleaningOverride extends Model {

    protected string $table = 'cleaning_overrides';

    protected static $fillable = [
        'house',
        'room',
        'tenant',
        'week',
        'year',
    ];

}