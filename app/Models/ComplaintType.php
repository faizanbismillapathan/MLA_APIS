<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintType extends Model
{
    use HasFactory;
    protected $table = "complaint_types";
    public $fillable = [
        'complaintTypeName',
        'catagoryId',
        'updated_by',
        'created_by',
        'isActive',
    ];
}
