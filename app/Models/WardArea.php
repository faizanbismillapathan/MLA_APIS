<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardArea extends Model
{
    use HasFactory;
    protected $table='wardArea';
    protected $fillable=[
        'wardAreaName','wardId','created_by','updated_by','isActive'
    ];
}
