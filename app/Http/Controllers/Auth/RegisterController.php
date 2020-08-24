<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function showRegistrationForm() {
        Log::debug('デバッグメッセージ');
        Log::debug(session('url.intended'), ['line' => __LINE__, 'file' => __FILE__]);
        Log::debug(session('favorite_url'), ['line' => __LINE__, 'file' => __FILE__]);
        Log::debug(session('back_url'), ['line' => __LINE__, 'file' => __FILE__]);

        return view('auth.register');
    }
    
    protected function registered(Request $request, $user) {
        // Log::debug('registeredメッセージ');
        // Log::debug(session('favorite_url'));


        ###############################
        #
        # 未登録時のお気に入りリダイレクト処理
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
