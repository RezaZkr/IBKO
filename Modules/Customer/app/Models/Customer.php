<?php

namespace Modules\Customer\Models;


use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class Customer extends Authenticatable
{
    use  HasApiTokens, Notifiable, SoftDeletes;


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
