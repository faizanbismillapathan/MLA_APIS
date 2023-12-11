<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'citizens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'gender',
        'number',
        'altNumber',
        'password',
        'visiblePassword',
        'role',
        'office',
        'dob',
        'education',
        'occupation',
        'cast',
        'subCast',
        'addNote',
        'photo',
        'aadharNumber',
        'panNumber',
        'voterId',
        'rationCard',
        'assemblyId',
        'cityType',
        'zillaParishadId',
        'talukaPanchayatId',
        'gaonId',
        'wardId',
        'wardAreaId',
        'pincode',
        'add1',
        'add2',
        'nativePlace',
        'accNo',
        'partNo',
        'sectionNumber',
        'slnNumberInPart',
        'bjpVoter',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
