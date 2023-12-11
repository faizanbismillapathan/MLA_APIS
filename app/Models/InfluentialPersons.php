<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluentialPersons extends Model
{
    use HasFactory;
    protected $table = "influential_persons";
    protected $primaryKey = 'Influential_Persons_ID';
    public $fillable = [
        'GoanID',
        'Degisnation',
        'Name_ID',
        'Society',
        'Status',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
