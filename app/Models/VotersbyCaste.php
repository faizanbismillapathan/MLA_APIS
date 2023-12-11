<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotersbyCaste extends Model
{
    use HasFactory;
    protected $table = "voters_by_caste";
    protected $primaryKey = 'Voters_by_Caste_ID';
    public $fillable = [
        'GoanID',
        'Cast_OR_Community_Name',
        'Number',
        'Remark',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
