<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $table='ward';
    protected $fillable=[
        'wardName','assemblyId','created_by','updated_by','isActive'
    ];
}
