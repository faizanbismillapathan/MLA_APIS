<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialElementMaster extends Model
{
    use HasFactory;
    protected $table = "social_element_master";
    protected $primaryKey = 'social_element_Master_ID';
    public $fillable = [
        'social_element_Name',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
