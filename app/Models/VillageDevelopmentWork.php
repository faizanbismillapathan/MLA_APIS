<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageDevelopmentWork extends Model
{
    use HasFactory;
    protected $table = "Village_Development_works";
    protected $primaryKey = 'Village_Development_works_ID';
    public $fillable = [
        'GoanID',
        'Work_Name',
        'Price',
        'Head_Year',
        'Work_Reference',
        'Status',
    ];
}
