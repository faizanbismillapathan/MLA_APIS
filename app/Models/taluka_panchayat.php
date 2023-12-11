<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taluka_panchayat extends Model
{
    use HasFactory;

    protected $table = "taluka_panchayats";
    public $fillable = [
        'talukaPanchayatName',
        'zillaParishadId',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
