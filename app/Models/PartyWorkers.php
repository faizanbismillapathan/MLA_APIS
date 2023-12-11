<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyWorkers extends Model
{
    use HasFactory;
    protected $table = "party_workers";
    protected $primaryKey = 'Party_Workers_ID';
    public $fillable = [
        'GoanID',
        'Party',
        'Name_ID',
        'Party_Responsibility',
        'Status',
        'created_by',
        'updated_by',
        'isActive',
        'type',
    ];
}
