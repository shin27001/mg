<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'title', 'comment', 'reply_flg', 'status'
    ];

    protected $enumCasts = [
        'status' =>  \App\Enums\SupportStatus::class,
     ];

     public function replies()
     {
         return $this->hasMany('App\InquiryReply');
     }
     public function user()
     {
         return $this->belongsTo('App\User');
     }
}
