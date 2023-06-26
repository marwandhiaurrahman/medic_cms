<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

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

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        try {
            $user_google    = Socialite::driver('google')->user();
            $user           = User::firstWhere('email', $user_google->email);
            //jika user ada maka langsung di redirect ke halaman home
            if ($user) {
                $user->update([
                    'email' => $user_google->email,
                    'name' => $user_google->name,
                    'google_id' => $user_google->id,
                    'avatar' => $user_google->avatar,
                    'avatar_original' => $user_google->avatar_original,
                ]);
                auth()->login($user, true);
            }
            //jika user tidak ada maka simpan ke database
            else {
                //$user_google menyimpan data google account seperti email, foto, dsb
                $user = User::Create([
                    'email' => $user_google->email,
                    'name' => $user_google->name,
                    'password' => Hash::make('password'),
                    'google_id' => $user_google->id,
                    'avatar' => $user_google->avatar,
                    'avatar_original' => $user_google->avatar_original,
                ]);
                $user->assignRole('Pasien');
                auth()->login($user, true);
            }
            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }
}
