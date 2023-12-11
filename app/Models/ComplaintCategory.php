<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintCategory extends Model
{
    use HasFactory;
    protected $table='complaint_category';
    protected $fillable=[
        'complaintCategoryName','created_by','updated_by','isActive'
    ];
    // protected $fillable=[
    //     'ComplaintCategoryName','created_by','updated_by','isActive'
    // ];
}
