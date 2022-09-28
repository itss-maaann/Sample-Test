<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name','phone','email','password','photo'
    ]; //← the fields name inside the array is mass-assignable

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'password', 'password', 'remember_token',
    ];

    protected $guarded = ['id']; //← the field name inside the array is not mass-assignable

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /********** RelationShips Start **********/


    /********** RelationShips End **********/


    /********** Accessor Start **********/
    public function setPasswordAttribute($pass){

        $this->attributes['password'] = Hash::make($pass);

        }
    /********** Accessor End **********/
}
