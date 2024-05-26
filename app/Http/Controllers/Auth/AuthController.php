<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();
        
        if(!empty($request->input('remember')) && $request->input('remember') == 'on')
        {
            $remember = true;
        }
        
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    public function doLogout()
    {
        Auth::logout();
        return to_route('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function doRegistration(RegisterRequest $request)
    {
        $user_data = $request->validated();

        $user_data['optin_newsletter'] = $request->input('optin_newsletter') ? 1 : 0;

        User::create($user_data);

        return to_route('auth.login')->with('success', 'Félicitations, votre compte a bien été créé !');
    }
}
