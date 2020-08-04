<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InquiryReply extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'inquiry_id', 'comment'
    ];
    
    
}
