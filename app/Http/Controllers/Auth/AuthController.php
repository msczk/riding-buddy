<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\Auth\NewRegistration;

class AuthController extends Controller
{
    /**
     * Return the login view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login(): \Illuminate\Contracts\View\View
    {
        return view('auth.login');
    }

    /**
     * Do the login action
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogin(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->validated();
        
        if(!empty($request->input('remember')) && $request->input('remember') == 'on')
        {
            $remember = true;
        }else{
            $remember = false;
        }
        
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Do the logout action
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        return to_route('auth.login');
    }

    /**
     * Return the registration view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function register(): \Illuminate\Contracts\View\View
    {
        return view('auth.register');
    }

    /**
     * Do the registration action
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doRegistration(RegisterRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user_data = $request->validated();

        $user_data['optin_newsletter'] = $request->input('optin_newsletter') ? 1 : 0;

        $user = User::create($user_data);

        $user->notify(new NewRegistration());

        return to_route('auth.login')->with('success', 'Félicitations, votre compte a bien été créé !');
    }
}
