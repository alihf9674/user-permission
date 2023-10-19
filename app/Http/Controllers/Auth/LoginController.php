<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validateForm($request);
        $user = $this->getUser($request);
        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended();
    }

    public function destroy()
    {
        session()->invalidate();
        Auth::logout();
        return redirect('/');
    }

    protected function getUser($request)
    {
        return User::where('email', $request->email)->firstOrFail();
    }

    protected function validateForm(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required'],
        ]);
    }
}
