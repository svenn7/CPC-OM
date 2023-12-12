<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        if (Auth::check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role === 'officer') {
                return redirect()->route('officer.dashboard');
            } elseif (auth()->user()->role === 'student') {
                return redirect()->route('student/home');
            }
        }

        return view('welcome');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_no' => 'required',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('id_no', 'password');

            if (!auth()->attempt($credentials)) {
                throw new \Exception('Invalid credentials');
            }

            $request->session()->regenerate();

            $url = '';
            if (auth()->user()->role === 'admin') {
                $url = '/admin/dashboard';
            } elseif (auth()->user()->role === 'officer') {
                $url = '/officer/dashboard';
            } elseif (auth()->user()->role === 'student') {
                $url = '/student/home';
            }

            return redirect()->intended($url);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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
