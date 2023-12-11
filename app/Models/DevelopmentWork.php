<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevelopmentWork extends Model
{
    use HasFactory;
    protected $table='development_work';
    protected $fillable=[
        'developmentWorkName','created_by','updated_by','isActive'
    ];
}
