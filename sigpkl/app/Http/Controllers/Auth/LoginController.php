<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;
use App\Models\Province;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Google_Client;
use Google_Service_People;
use Illuminate\Database\Eloquent\Scope;
use App\Models\School;

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

    public function index()
    {
        $sch = School::where('id', 1)->first();
        return view('auth.login', compact('sch'));
    }

    public function login(Request $request)
    {
        // return $request->input();
        $rules = [
            'username'              => 'required',
            'password'              => 'required'
        ];

        $messages = [
            'username.required'     => 'Username wajib diisi',
            'password.required'     => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'username'  => $request->input('username'),
            'password'  => $request->input('password'),
        ];

        // cek username
        $cekuser = User::where('username', '=', $request->username)->first();

        if ($cekuser) {
            if (Hash::check($request->password, $cekuser->password)) {
                Auth::attempt($data);

                if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
                    //Login Success
                    $request->session()->put('LoggedUser', $cekuser->id);
                    return redirect()->route('home');
                } else { // false
                    //Login Fail
                    Session::flash('fai', 'Username atau Password salah!');
                    return redirect()->back();
                }
            } else {
                //Login Fail
                Session::flash('fai', 'Password yang dimasukkan salah!');
                return redirect()->back();
            }
        } else {
            //Login Fail
            Session::flash('fai', 'Username tidak dapat ditemukan!');
            return redirect()->back();
        }
    }

    public function redirectToGoogle(Request $request)
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $id = $user->getId();
            $mai = $user->getEmail();

            $finduser = User::where('email', $mai)->first();
            if ($finduser) {
                $findid = User::where('email', $mai)->where('id_gmail', $id)->first();
                if ($findid) {
                    Auth::login($finduser);
                    return redirect()->intended('home');
                } else {
                    $save = User::where('email', $mai)
                        ->update([
                            'id_gmail' => $id,
                        ]);
                    if ($save) {
                        Auth::login($finduser);
                        return redirect()->intended('home');
                    }
                }
            } else {
                return redirect()->route('login')->with('fai', 'Akun Google yang dipilih tidak sesuai dengan email yang didaftarkan');
            }
        } catch (\Exception $e) {
        }
    }
}
