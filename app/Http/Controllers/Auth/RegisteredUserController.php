<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

public function store(Request $request): RedirectResponse
{
    $request->validate([
    'name' => ['required', 'string', 'max:255', 'unique:users,name'], // <-- tambahkan unique di name
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
]);



    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    } catch (\Exception $e) {
        return back()->withErrors(['register_error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.']);
    }
}
}
