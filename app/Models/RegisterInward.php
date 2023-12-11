<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterInward extends Model
{
    use HasFactory;
    protected $table='registerInward';
    protected $fillable=[
        'letterTypeId','departmentId','fileNumber','priority','letterReleaseDate','note','assemblyId','cityType','wardId','wardAreaId','zillaParishadId','talukaPanchayatId','gaonId','documentFrom','deliveredBy','created_by','updated_by','isActive'
    ];
}
