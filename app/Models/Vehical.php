<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehical extends Model
{
    use HasFactory;
    protected $table='vehical';
    protected $fillable=[
        'name','number','fuelType','created_by','updated_by','isActive'
    ];
}
