<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $table = "invitations";
    public $fillable = [
        'eventTypeId',
        'eventDate',
        'eventTime',
        'eventAddress',
        'mulacheName',
        'mulicheName',
        'haldiPlace',
        'haldidate',
        'routeId',
        'priority',
        'note',
        'assemblyId',
        'cityType',
        'wardId',
        'wardAreaId',
        'zillaParishadId',
        'talukaPanchayatId',
        'gaonId',
        'isActive',
        'created_by',
        'updated_by',
    ];

    public function Image()
    {
        return $this->hasMany(Images::class);
    }
}
