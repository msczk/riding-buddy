<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\Auth\RegisterRequest;
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
            'email' => __('Invalid credentials'),
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

        return to_route('auth.login')->with('success', __('Congratulations, your account has been created!'));
    }

    public function forgot()
    {
        return view('auth.forgot-password');
    }

    public function sendForgot(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['success' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function reset(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function doReset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('auth.login')->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
