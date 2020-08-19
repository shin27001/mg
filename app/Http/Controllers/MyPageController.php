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
        if (!$user->profile) {
            return redirect('/mypage/create'); 
        }

        $posts = $this->get_favorites($user);
        return view('profiles.edit', [
            'user' => $user,
            'posts' => $posts,
        ]); 
    }

    public function create() 
    {   
        $user = \Auth::user();
        if ($user->profile) {
            return redirect('/mypage'); 
        }

        return view('profiles.create', [ 
            'user' => $user
        ]); 
    } 

    public function store(Request $request) 
    {

        $validator = \Validator::make($request->all(), [
            'user_id'  => 'required',
            'nickname' => 'required|unique:profiles|max:20',
            'zip_code' => 'required|max:8',
            'address'  => 'required|max:150',
            'tel_no'   => 'required|max:15',
        ],[
            'user_id.required'  => 'ユーザIDが不明です。新規登録を行って下さい。',
            'nickname.required' => 'ニックネームを入力して下さい。',
            'zip_code.required' => '郵便番号を入力して下さい。',
            'address.required'  => '住所を入力して下さい。',
            'tel_no.required'   => '電話番号を入力して下さい。',
            'nickname.max' => 'ニックネームは20文字以内で入力して下さい。',
            'zip_code.max' => '郵便番号は8桁で入力して下さい。',
            'address.max'  => '住所は150文字以内で入力して下さい。',
            'tel_no.max'   => '電話番号は15桁以内で入力して下さい。',
            'nickname.unique' => 'このニックネームはすでに登録があります。他のニックネームをご登録下さい。',
        ]);
        //バリデーションルールにでエラーの場合 
        if ($validator->fails()) {
            return redirect('/mypage/create')->withInput()->withErrors($validator);
        }
 
        $profile = new Profile; 
        $profile->fill($request->all()); 
        $profile->save();

        return redirect('/mypage')->with('flash_message', 'プロフィールの登録が完了しました！'); 
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
        // $validator = \Validator::make($request->all(), [
        //     'user_id'  => 'required',
        //     'nickname' => 'required',
        //     'zip_code' => 'required',
        //     'address'  => 'required',
        //     'tel_no'   => 'required',
        // ],[
        //     'user_id.required'  => 'ユーザIDが不明です。新規登録を行って下さい。',
        //     'nickname.required' => 'ニックネームを入力して下さい。',
        //     'zip_code.required' => '郵便番号を入力して下さい。',
        //     'address.required'  => '住所を入力して下さい。',
        //     'tel_no.required'   => '電話番号を入力して下さい。',
        // ]);

        $validator = \Validator::make($request->all(), [
            'user_id'  => 'required',
            'nickname' => 'required|max:20',
            'zip_code' => 'required|max:8',
            'address'  => 'required|max:150',
            'tel_no'   => 'required|max:15',
        ],[
            'user_id.required'  => 'ユーザIDが不明です。新規登録を行って下さい。',
            'nickname.required' => 'ニックネームを入力して下さい。',
            'zip_code.required' => '郵便番号を入力して下さい。',
            'address.required'  => '住所を入力して下さい。',
            'tel_no.required'   => '電話番号を入力して下さい。',
            'nickname.max' => 'ニックネームは20文字以内で入力して下さい。',
            'zip_code.max' => '郵便番号は8桁で入力して下さい。',
            'address.max'  => '住所は150文字以内で入力して下さい。',
            'tel_no.max'   => '電話番号は15桁以内で入力して下さい。',
        ]);
        //バリデーションルールにでエラーの場合 
        if ($validator->fails()) {
            return redirect('/mypage/'.$request->input('user_id').'/edit')->withInput()->withErrors($validator);
        }

        $profile = Profile::find($id);
        $profile->fill($request->all()); 
        $profile->save();
        return redirect('/mypage')->with('flash_message', 'プロフィールの更新が完了しました！'); 
    } 
    
    
    public function destroy($id) 
    { 
        $user = User::find($id); 
        $user->delete();
        return redirect(env('WP_URL')); 
    } 

}
