<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintCatagory extends Model
{
    use HasFactory;
    protected $table = "complaint_catagories";
    public $fillable = [
        'catagoryName',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
