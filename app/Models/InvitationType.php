<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitationType extends Model
{
    use HasFactory;
    public $table = "invitation_types";
    public $fillable = [
        'invitationTypeName',
        'created_by',
        'updated_by',
        'isActive',
    ];
}
