<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect users to login page after logout.
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    /**
     * Redirect users after login based on role.
     */
    protected function redirectTo()
    {
        return Auth::user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard');
    }

    /**
     * Flash a success message after the user is authenticated.
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectTo())
            ->with('success', 'Login berhasil. Selamat datang, ' . $user->name . '!');
    }
}
