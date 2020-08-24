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
        setcookie("user_info", "", time()-60*60*60, '/', env('WP_SESSION_DOMAIN'));

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
        // \Log::debug(parse_url(url()->previous()), ['file' => __FILE__, 'line' => __LINE__]);
        $hosts = array('rlf.local', 'gohan-tabi.com');
        $referer_url = parse_url(url()->previous());
        session(['pref' => 'okinawa']); //初期値
        if((in_array($referer_url['host'], $hosts)) && (!empty($_SERVER['HTTP_REFERER']))) {
            $pref = (strpos($_SERVER['HTTP_REFERER'], 'okinawa')) ? "okinawa" : "kyoto";
            session(['pref' => $pref]);
        }
        
        // \Log::debug('showLoginForm', ['line' => __LINE__, 'file' => __FILE__]);
        // \Log::debug($request->page,  ['line' => __LINE__, 'file' => __FILE__]);
        // \Log::debug(session('pref'), ['line' => __LINE__, 'file' => __FILE__]);
        

        ##########################
        # 未ログインで、
        # ログインボタンを押された時
        # の処理
        ##########################
        if ($request->input('page')) {
            # ログイン後、「mypage」へ遷移
            session(['url.intended' => $request->input('page')]);
            return view('auth.login');
        }
        
        ##########################
        # 未ログインで、
        # お気に入りボタンを押された時
        # の処理
        ##########################
        session(['back_url' => 'mypage']);
        if (empty(session('back_url'))) {
            if (array_key_exists('HTTP_REFERER', $_SERVER)) {
                # ログイン後、店舗詳細へ戻る
                session(['back_url' => $_SERVER['HTTP_REFERER']]);
                // session(['url.intended' => $_SERVER['HTTP_REFERER']]);
                // $path = parse_url($_SERVER['HTTP_REFERER']); // URLを分解
            }
        }
        \Log::debug(session('back_url'), ['line' => __LINE__, 'file' => __FILE__]);

        return view('auth.login');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {

        // \Log::debug('authenticated', ['line' => __LINE__, 'file' => __FILE__]);
        // \Log::debug(session('back_url'), ['line' => __LINE__, 'file' => __FILE__]);
        // \Log::debug(session('favorite'), ['line' => __LINE__, 'file' => __FILE__]);
        

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


        ###############################
        #
        # 未ログイン時のお気に入り登録処理
        #
        ###############################
        if (session('url.intended') == 'mypage') {
            // \Log::debug('url.intended - go', ['line' => __LINE__, 'file' => __FILE__]);
            return redirect(session('url.intended'));
        } elseif(!empty(session('favorite_url'))) {
            // \Log::debug('favorite_url - go', ['line' => __LINE__, 'file' => __FILE__]);
            return redirect(session('favorite_url'));
        } elseif(!empty(session('back_url'))) {
            // \Log::debug('back_url - go', ['line' => __LINE__, 'file' => __FILE__]);
            return redirect(session('back_url'));
        }
        // \Log::debug('url.intended - end go', ['line' => __LINE__, 'file' => __FILE__]);
        return redirect(session('url.intended'));
    }
}
