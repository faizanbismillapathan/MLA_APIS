<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterOutward extends Model
{
    use HasFactory;
    protected $table='registerOutward';
    protected $fillable=[
        'letterTypeId','departmentId','fileNumber','priority','letterReleaseDate','note','assemblyId','cityType','wardId','wardAreaId','zillaParishadId','talukaPanchayatId','gaonId','documentFor','receivedBy','created_by','updated_by','isActive'
    ];
}
