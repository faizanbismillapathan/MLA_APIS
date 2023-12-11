<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adhikari extends Model
{
    use HasFactory;
    protected $table='adhikari';
    protected $fillable=[
        'firstName','middleName','lastName','gender','mobileNo','alternateNo','departmentId','designation','education','dateOfBirth','address','photo','created_by','updated_by','isActive'
    ];
}
