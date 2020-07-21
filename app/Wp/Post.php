<?php

namespace App\Wp;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function post_metas()
    {
     return $this->hasMany('App\Wp\PostMeta', 'post_id');
    }        
}
