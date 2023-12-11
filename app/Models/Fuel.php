<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;
    protected $table='fuel';
    protected $fillable=[
        'date','vehicalId','driverId','fuel','fuelAmount','startReading','endReading', 'KM', 'tourDetail','tourReason','maintenanceAmount','maintenanceDetail','created_by','updated_by','isActive'
    ];
}
