<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "given_names",
        "sur_name",
        "login",
        "password",
    ];
}
/* 
status :{
    registred: yangi loginda otgandagi status
    access: malumotlari toliq bolgandagi holat



    
    transpost_date: haydovchi malumotlarni toldrish kk 
}
*/
