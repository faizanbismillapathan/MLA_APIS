<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $table = "event_types";
    public $fillable = [
        'eventTypeName',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
