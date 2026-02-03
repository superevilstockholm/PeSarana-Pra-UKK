<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\User;
use App\Models\MasterData\Student;

// Enums
use App\Enums\RoleEnum;

class AuthController extends Controller
{
    public function login(Request $request): View | RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('dashboard.' . $request->user()->role . '.index');
        }
        if ($request->isMethod('get')) {
            return view('pages.auth.login');
        }
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);
        $user = User::where('email', $validated['email'])->first();
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors('Email atau Password salah.')->withInput();
        }
        $user->tokens()->delete();
        $plainToken = $user->createToken('auth-token', ['*'], Carbon::now()->addDays(7))->plainTextToken;
        return redirect()->route('dashboard.' . $user->role->value . '.index')->with('success', 'Berhasil masuk.')->withCookie(cookie(
            'auth-token',
            $plainToken,
            60 * 24 * 7,
        ));
    }

    public function signup(Request $request): View | RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('dashboard.' . $request->user()->role . '.index');
        }
        if ($request->isMethod('get')) {
            return view('pages.auth.signup');
        }
        $validated = $request->validate([
            'nisn' => 'required|digits:10',
            'dob' => 'required|date',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255',
        ]);
        $student = Student::with('user')->where('nisn', $validated['nisn'])->whereDate('dob', $validated['dob'])->first();
        if (!$student) {
            return back()->withErrors('NISN atau Tanggal Lahir salah.')->withInput();
        }
        if ($student->user_id || $student->user) {
            return back()->withErrors('Siswa dengan NISN ' . $validated['nisn'] . ' sudah mendaftar.')->withInput();
        }
        unset($validated['nisn'], $validated['dob']);
        $validated['name'] = $student->name;
        $validated['role'] = RoleEnum::STUDENT;
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $student->update([
            'user_id' => $user->id,
        ]);
        return redirect()->route('login')->with('success', 'Berhasil membuat user.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->user()->tokens()->delete();
        return redirect()->route('login')->withoutCookie('auth-token');
    }
}
