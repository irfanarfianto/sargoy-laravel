<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Attempt to authenticate the user
        $request->authenticate();

        // Check if the user's email is verified
        // if (!Auth::user()->hasVerifiedEmail()) {
        //     return redirect()->route('verification.notice');
        // }

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        if (Auth::user()->hasRole('admin|demo_admin')) {
            return redirect()->intended(route('admin'));
        }

        if (Auth::user()->hasRole('seller|demo_seller')) {
            return redirect()->intended(route('seller'));
        }

        return redirect()->intended(url('/'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
