<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposedWork extends Model
{
    use HasFactory;
    protected $table = "proposed_work";
    protected $primaryKey = 'proposed_Work_ID';
    public $fillable = [
        'goanID',
        'workName',
        'price',
        'reference',
        'priority',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
