<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $table='images';
    protected $fillable=[
        'documentName','documentType','typeId','created_by','updated_by','isActive'
    ];
   
}

/*class Images extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'documentName', 'documentType', 'typeId', 'created_by', 'updated_by', 'isActive'
    ];

    public function complaintDetails()
    {
        return $this->belongsTo(ComplaintDetails::class, 'typeId');
    }
}*/
