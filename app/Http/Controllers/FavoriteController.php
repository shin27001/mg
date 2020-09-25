<?php

namespace App\Http\Controllers;

use App\Favorite;
use Illuminate\Http\Request;
// use Auth;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{

    public function __construct(Request $request)
    {        
        // セッションへ遷移先ページを保存
        if ($request->input('page')) {
            # ログイン後、パラメータ「page」で設定したルーティングへ遷移
            session(['page' => $request->input('page')]);
        }
        //お気に入りURLを保存
        session(['favorite' => url()->full()]);

        // 認証チェック
        $this->middleware('auth');
    }

    public function auth()
    {
        \Debugbar::disable();
        return response()->json(['auth' => \Auth::check()]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pref, $shop_id, $shop_slug)
    {   
        # ユーザ情報を取得ß
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
        
        // sessionの「page」を削除してからリダイレクト
        $redirect_page = session('page');
        session()->forget('page');
        return redirect($redirect_page);
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
