<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\User;

// Enums
use App\Enums\RoleEnum;

class AuthController extends Controller
{
    public function login(Request $request): View | RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('dasboard.' . $request->user()->role . '.index');
        }
        if ($request->isMethod('get')) {
            return view('pages.auth.login');
        }
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);
        $user = User::where('email', $validated['email'])->first();
        if (!$user || Hash::check($validated['password'], $user->password)) {
            return back()->withErrors('Email atau Password salah.')->withInput();
        }
        return redirect()->route('dashboard.' . $user->role->value . '.index')->with('success', 'Berhasil masuk.');
    }
}
