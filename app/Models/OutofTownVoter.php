<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutofTownVoter extends Model
{
    use HasFactory;
    protected $table = "out-of-town_voter";
    protected $primaryKey = 'Out_of_Town_Voter_ID';
    public $fillable = [
        'goanID',
        'name_ID',
        'society',
        'voter_List_No',
        'reference',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
