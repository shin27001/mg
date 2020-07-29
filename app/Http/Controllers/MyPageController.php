<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;
use App\Wp\Post;
use App\Wp\PostMeta;

use App\Wp\Connection;

class MyPageController extends Controller
{   
    public function db_name($pref) {
        return ($pref == 'okinawa') ? 'mysql_wp_ok' : 'mysql_wp_kt';
    }
    public function get_favorites(User $user) {
        $post = new Post;
        $meta = new PostMeta;
        $posts = [];
        foreach ($user->favorites as $key => $favorite) {
            $post->setConnection($this->db_name($favorite->pref));
            $meta->setConnection($this->db_name($favorite->pref));

            $p = $post->find($favorite->shop_id);
            if($p->isEmpty) { continue; }
            $p->favorite = $favorite;
            $p->tanto_name = $meta->get_meta($p->ID, 'tanto_name');
            $p->address = $meta->get_meta($p->ID, 'address');
            $p->tel_no = $meta->get_meta($p->ID, 'tel_no');

            #画像取得
            $image = $meta->get_meta($p->ID, 'shop_main_image');
            $p->shop_main_image = $post->find($image->meta_value);
            // dd($image);
            $posts[] = $p;
        }
        return $posts;
    }

    
    public function index()
    {
        $user = \Auth::user();

        dd($user);

        $posts = $this->get_favorites($user);
        return view('profiles.edit', [
            'user' => $user,
            'posts' => $posts,
        ]); 
    }

    public function create() 
    {   
        $user = \Auth::user();
        return view('profiles.create', [ 
            'user' => $user
        ]); 
    } 

    public function store(Request $request) 
    {
        $profile = new Profile; 
        $profile->fill($request->all()); 
        $profile->save(); 
        return redirect('/mypage'); 
    } 

    // public function show($id) 
    // { 
    //     $profile = Profile::find($id); 
    //     return view('profiles.show', [ 
    //         'profile' => $profile, 
    //     ]); 
    // } 

    public function edit($id) 
    { 
        $user = User::find($id);
        $posts = $this->get_favorites($user);
        return view('profiles.edit', [ 
            'user' => $user,
            'posts' => $posts,
        ]); 
    } 

    public function update(Request $request, $id) 
    {   
        $profile = Profile::find($id);
        $profile->fill($request->all()); 
        $profile->save();
        return redirect('/mypage'); 
    } 
    
    
    public function destroy($id) 
    { 
        $user = User::find($id); 
        $user->delete();
        return redirect(env('WP_URL')); 
    } 

}
