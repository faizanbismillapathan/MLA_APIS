<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaon extends Model
{
    use HasFactory;
    protected $table='gaon';
    protected $fillable=[
        'gaonName','talukaPanchayatId','created_by','updated_by','isActive'
    ];
}
