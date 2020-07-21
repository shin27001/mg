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
    public function index()
    {
        $user = \Auth::user();
        // dd($user->profile);
        // dd($user->favorites);

        // $cn = new Connection;
        // $post = new Post;
        // $post->setConnection('mysql_wp_kt');
        // $p = $post->find(168);
        // dd($post);

        $post = new Post;
        $meta = new PostMeta;
        foreach ($user->favorites as $key => $favorite) {
            
            $post->setConnection($this->db_name($favorite->pref));
            $meta->setConnection($this->db_name($favorite->pref));

            $p = $post->find($favorite->shop_id);
            $p->tanto_name = $meta->get_meta($p->ID, 'tanto_name');
            dd($p->tanto_name[0]->meta_value);
            $posts[] = $p;
            
            // dd($posts[0]->post_metas);
        }
        // dd($posts[0]->post_metas);

        return view('profiles.edit', [ 
            'user' => $user,
            'posts' => $posts
        ]); 
    //    $users = User::all();
    //    return view('profiles.index', [
    //    'users' => $users, 
    //    ]);
    }

    public function create() 
    {   
        $user = \Auth::user();
        // print_r($user);

        $profile = new Profile; 
        return view('profiles.create', [ 
            // 'profile' => $profile,
            'user' => $user
        ]); 
    } 

    public function store(Request $request) 
    {
        $profile = new Profile; 
        $profile->fill( $request->all() ); 
        $profile->save(); 
        return redirect('/mypage/'.$profile->user_id.'/edit'); 
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
        return view('profiles.edit', [ 
            'user' => $user,
        ]); 
    } 

    public function update(Request $request, $id) 
    {   
        $profile = Profile::find($id);
        $profile->fill($request->all()); 
        $profile->save(); 
        return redirect('/mypage/'.$profile->user_id.'/edit'); 
    } 
    // public function destroy($id) 
    // { 
    //     $profile = Profile::find($id); 
    //     $profile->delete(); 
    //     return redirect('/profiles'); 
    // } 

}
