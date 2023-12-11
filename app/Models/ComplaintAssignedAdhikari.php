<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintAssignedAdhikari extends Model
{
    use HasFactory;
    protected $table='complaint_assigned_adhikari';
    protected $fillable=[
        'complaintDetailsId','adhikariId','created_by','updated_by','isActive'
    ];
}
