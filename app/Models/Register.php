<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    protected $table='register';
    protected $fillable=[
        'token','letterTypeId','departmentId','fileNumber','priority','letterReleaseDate','note','assemblyId','cityType','wardId','wardAreaId','zillaParishadId','talukaPanchayatId','gaonId','documentFrom','deliveredBy','documentFor','receivedBy','registerType','status','outwardId','created_by','updated_by','isActive'
    ];
}
