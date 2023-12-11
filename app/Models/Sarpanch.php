<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sarpanch extends Model
{
    use HasFactory;
    protected $table = "sarpanch_etc";
    protected $primaryKey = 'Sarpanch_etc_ID';
    public $fillable = [
        'GoanID',
        'Degisnation',
        'Year',
        'Name_ID',
        'Remark',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
