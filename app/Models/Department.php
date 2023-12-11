<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = "departments";
    public $fillable = [
        'departmentName',
        'complaintTypeId',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
