<?php

namespace App\Wp;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $table = 'postmeta';

    public function get_meta($post_id, $key) {
        // $this->find();
        return $this->where('post_id', $post_id)->where('meta_key', $key)->get();
    }
}
