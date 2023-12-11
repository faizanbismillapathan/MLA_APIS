<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintDetails extends Model
{
    use HasFactory;
    protected $table='complaint_details';
    protected $fillable=[
        'complainerId','issue','actualComplaintDate','complaintCategoryId','complaintSubCategoryId','complaintDueDate','address','pincode','assemblyId','cityType','gaonId','talukaPanchayatId','zillaParishadId','wardId','wardAreaId','followUp','status','document','karyakartaId','adhikariId','created_by','updated_by','isActive'
    ];
}

/*class ComplaintDetails extends Model
{
    use HasFactory;
    protected $table='complaint_details';
    protected $fillable=[
        'complainerId','issue','actualComplaintDate','complaintCategoryId','complaintSubCategoryId','complaintDueDate','address','pincode','assemblyId','cityType','gaonId','talukaPanchayatId','zillaParishadId','wardId','wardAreaId','followUp','status','document','karyakartaId','adhikariId','created_by','updated_by','isActive'
    ];
    
     public function images()
    {
        return $this->hasMany(Images::class, 'typeId');
    }
}*/



