<?php

namespace App\Wp;

use Illuminate\Database\Eloquent\Model;
use App\Wp\Post;

class PostMeta extends Model
{
    protected $table = 'postmeta';

    public function get_meta($post_id, $key) {
        // $this->find();
        // $this->hasMany(Member::class)->where('status', 'active');
        return $this->where('post_id', $post_id)->where('meta_key', $key)->first();
        // return $this->where('post_id', $post_id)->where('meta_key', $key)->get();
    }
    // public function get_main_image($post_id) {
    //     $main_image_meta = $this->where('post_id', $post_id)->where('meta_key', 'shop_main_image')->first();
    //     return Post::find($main_image_meta->meta_value);
    // }

}
