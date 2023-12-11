<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialElement extends Model
{
    use HasFactory;
    protected $table = "social_element";
    protected $primaryKey = 'social_element_ID';
    public $fillable = [
        'goanID',
        'componentID', // social element master id
        'nameID',
        'remark',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
