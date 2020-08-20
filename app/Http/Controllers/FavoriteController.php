<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
// use Auth;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{

    public function __construct()
    {

        // $path = parse_url($_SERVER['HTTP_REFERER']); // URLを分解
        // echo url()->full();
        Log::debug(url()->full(), ['file' => __FILE__, 'line' => __LINE__]);
        Log::debug(parse_url(url()->full()), ['file' => __FILE__, 'line' => __LINE__]);
        

        if (!\Auth::check()) {
            Log::debug('ログインしていない');
            // セッションへ保存
            session(['favorite' => url()->full()]);
        }

        // dd(url());
        // $path = parse_url(url()->full());
        // if (!empty($path['path'])) {
        //     list($controller, $pref, $shop_id, $shop_slug) = explode("/", $path['path']);
        //     if(!empty($shop_id)) {
        //         // セッションへ保存
        //         session(['url.favorite' => url()->full()]);
        //     }
        // }

        // $request->fullUrl()
        $this->middleware('auth');
    }

    public function auth()
    {
        \Debugbar::disable();
        // return "aaaaaaaaaaaaaa";
        // return json_encode(['auth' => \Auth::check()]);
        return response()->json(['auth' => \Auth::check()]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pref, $shop_id, $shop_slug)
    {   
        \Debugbar::disable();

        $user = \Auth::user();

        $favorite = Favorite::where('user_id', $user->id)->where('pref', $pref)->where('shop_id', $shop_id)->get();
        if($favorite->isEmpty()) {

            $favorite = new Favorite;
            $favorite->user_id = $user->id;
            $favorite->pref = htmlspecialchars($pref, ENT_QUOTES);
            $favorite->shop_id = htmlspecialchars($shop_id, ENT_QUOTES);
            $favorite->shop_slug = htmlspecialchars($shop_slug, ENT_QUOTES);
            $favorite->save();
        }
        session()->forget('favorite');

        # ユーザ情報(Cookie)更新処理
        # LoginControllerと二重に書いているので、整理しないといけない
        $favorites = array();
        foreach ($user->favorites as $key => $val) {
            $favorites[] = $val['pref'].$val['shop_id'];
        }
        $user_info = json_encode([
            'login_id'  => $user->email, 
            'nickname'  => ((empty($user->profile->nickname)) ? $user->name : $user->profile->nickname),
            'favorites' => $favorites,
        ]);
        # クッキーへ保存
        setcookie('user_info', $user_info, time()+24*60*60, '/', env('WP_SESSION_DOMAIN'));

        // Log::debug(session('url.intended'), ['file' => __FILE__, 'line' => __LINE__]);
        if (session('url.intended')) {
            return redirect(session('url.intended'));
        } else {
            return redirect(url()->previous());
        }

        // return response()->json();
        // exit;
        // return true;
        // print_r($request->all());
        
        // $favorite = new Favorite;
        // $favorite->fill( $request->all() ); 
        // $favorite->save(); 
        // print_r($favorite);
        // $user = \Auth::user();
        // if(!$user) {
        //   return redirect('/mypage/'.$profile->user_id.'/edit');
        // }
        // echo "id -- ".$id;
        // exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {   
        $favorite->delete();
        return redirect(url()->previous());
    }
}
