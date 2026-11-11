<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        // Keamanan: Paksa role menjadi 'tenant' untuk pendaftaran publik
        $user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => $request->password, // Di-hash otomatis oleh Model User
    'phone' => $request->phone,
    'role' => 'tenant',
    'status' => 'active',
]);

        Auth::login($user);

        return redirect()->route('tenant.dashboard');
    }
}