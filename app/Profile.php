<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $fillable = [
        'user_id', 'nickname', 'zip_code', 'address', 'tel_no', 'birthday', 
        'gender', 'self_introduce'
    ];
}
