<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhatavaniDetails extends Model
{
    use HasFactory;
    protected $table = "khatavani_details";
    protected $primaryKey = 'Khatavani_Details_ID';
    public $fillable = [
        'GoanID',
        'Total_number_of_voters',
        'No_of_booths',
        'Hindu',
        'Muslim',
        'Baudhaa',
        'Other',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
