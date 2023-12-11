<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintAssignedKaryakarta extends Model
{
    use HasFactory;
    protected $table='complaint_assigned_karyakarta';
    protected $fillable=[
        'complaintDetailsId','karyakartaId','created_by','updated_by','isActive'
    ];
}
