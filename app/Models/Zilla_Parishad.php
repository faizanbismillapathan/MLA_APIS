<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zilla_Parishad extends Model
{
    use HasFactory;
    protected $table = "zilla_parishads";
    public $fillable = [
        'zillaParishadName',
        'assemblyId',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
