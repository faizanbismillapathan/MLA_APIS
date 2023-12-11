<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;
    protected $table='userPermission';
    protected $fillable=[
        'permissionId','userId','created_by','updated_by','isActive'
    ];
}
