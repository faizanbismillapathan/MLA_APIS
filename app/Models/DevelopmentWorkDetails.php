<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevelopmentWorkDetails extends Model
{
    use HasFactory;
    protected $table='development_work_details';
    protected $fillable=[
        'developmentWorkId','proposedAmount','sanctionedAmount','workStartDate','tentiveFinishDate','workStatus','actualFinishDate',
        'assemblyId','cityType','gaonId','talukaPanchayatId','zillaParishadId',
        'wardId','wardAreaId','note','name','mobileNumber','alternateNumber','emailId','document','created_by','updated_by','isActive',
        'reference', 'head', 'priority'
    ];
}


