<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address1',
        'address2',
        'birth_date',
        'lat',
        'lng',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
