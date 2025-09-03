<?php
namespace App\Models;
use Support\Vault\Sanctum\Model;

class CleaningQueue extends Model {

    protected static $table = 'cleaning_queue';

    protected static $fillable = [
        'house',
        'type',
        'rotation',
        'start_date',
    ];


}