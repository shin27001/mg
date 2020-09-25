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
        # ログイン情報のクッキー削除
        session()->forget('pref');
        session()->forget('page');
        session()->forget('favorite');
        // setcookie("user_info", "", time()-60*60*60, '/', env('WP_SESSION_DOMAIN'));

        return redirect(env('WP_URL'));
    }

     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        ###############################
        #
        # 沖縄 or 京都 のどちらからログイン
        # されたかクッキーに保存
        #
        ###############################
        $hosts = array('gohan-tabi.com', 'rlf.local', 'gohan.sem-cloud.com');
        $referer_url = parse_url(url()->previous());
        session(['pref' => 'okinawa']); //初期値
        if((in_array($referer_url['host'], $hosts)) && (!empty($_SERVER['HTTP_REFERER']))) {
            $pref = (strpos($_SERVER['HTTP_REFERER'], 'okinawa')) ? "okinawa" : "kyoto";
            session(['pref' => $pref]);
        }
        
        ##########################
        # 未ログインで、
        # ログインボタンを押された時
        # の処理
        ##########################
        if ($request->input('page')) {
            # ログイン後、パラメータ「page」で設定したルーティングへ遷移
            session(['page' => $request->input('page')]);
            return view('auth.login');
        }
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
        # クッキーへ保存
        setcookie('user_info', $user_info, time()+24*60*60, '/', env('WP_SESSION_DOMAIN'));


        ###############################
        #
        # 未ログイン時のお気に入り登録処理
        #
        ###############################
        // \Log::debug('page - go favorite', ['line' => __LINE__, 'file' => basename(__FILE__)]);
        if (session('favorite')) {
            return redirect(session('favorite'));
        } elseif (session('page')) {
            return redirect(session('page'));
        }
        return redirect(session('url.intended'));
    }
}
