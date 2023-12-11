<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class votes_received_by_bjp extends Model
{
    use HasFactory;
    protected $table = "votes_received_by_bjp";
    protected $primaryKey = 'Votes_received_by_BJP_ID';
    public $fillable = [
        'GoanID',
        'Year',
        'Total_votes',
        'Received_votes',
        'Percentage',
        'Remark',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
