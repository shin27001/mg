<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/mypage';
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        //\Log::debug('ログアウト');
        // \Log::debug(env('WP_URL'));

        # ログイン情報のクッキー削除
        setcookie("user_info", "", time()-60*60*60, '/', env('WP_SESSION_DOMAIN'));
        return redirect(env('WP_URL'));
    }
    // public function redirectPath()
    // {   

    //     return '/mypage';

    //     $cookie = $_COOKIE['redirect_url'];
    //     setcookie('redirect_url', "", time()-60);
    //     return ($cookie) ? $cookie : '/mypage';
    // }

     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        \Log::debug('ログインフォーム');
        \Log::debug(parse_url($_SERVER['HTTP_REFERER']));

        $pref = (strpos($_SERVER['HTTP_REFERER'], 'okinawa')) ? "okinawa" : "kyoto";
        session(['pref' => $pref]);
        \Log::debug(session('pref'));

        if($request->page) {
            session(['url.intended' => '/'.$request->page]);
            return view('auth.login');
        }
        
        // ここから
        if (array_key_exists('HTTP_REFERER', $_SERVER)) {
            session(['url.intended' => $_SERVER['HTTP_REFERER']]);
            // $path = parse_url($_SERVER['HTTP_REFERER']); // URLを分解
        }
        // ここまで追加
        return view('auth.login');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        #############################
        #
        # ログイン情報をクッキーへ保存
        #
        #############################
        # お気に入りのデータを取得
        # (Max300件ぐらいがCookieの限界)
        $favorites = array();
        foreach ($user->favorites as $key => $val) {
            $favorites[] = $val['pref'].$val['shop_id'];
        }
        # 配列へJSON形式で格納 
        $user_info = json_encode([
            'login_id'  => $user->email, 
            'nickname'  => ((empty($user->profile->nickname)) ? $user->name : $user->profile->nickname),
            'favorites' => $favorites,
            //'client_ip' => \Request::ip(), 
            //'login_at'  => \DB::raw('now()')
        ]);
        // \Log::debug($user_info);
        # クッキーへ保存
        setcookie('user_info', $user_info, time()+24*60*60, '/', env('WP_SESSION_DOMAIN'));
    }
}
