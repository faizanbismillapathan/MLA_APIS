<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    use HasFactory;
    protected $table='assembly';
    protected $fillable=[
        'assemblyName','created_by','updated_by','isActive'
    ];
}
