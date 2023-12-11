<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintSubCategory extends Model
{
    use HasFactory;
    protected $table='complaint_sub_category';
    protected $fillable=[
        'complaintSubCategoryName','complaintCategoryId','created_by','updated_by','isActive'
    ];
}
