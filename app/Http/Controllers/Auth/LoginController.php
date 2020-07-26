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

}
