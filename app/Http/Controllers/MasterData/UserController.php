<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\User;
use App\Models\MasterData\Student;

// Enums
use App\Enums\RoleEnum;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $limit = $request->query('limit', 10);
        $query = User::query();
        $users = $limit === 'all'
            ? $query->get()
            : $query->paginate((int) $limit)
                ->appends($request->except('page'));
        return view('pages.dashboard.admin.master-data.user.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $students = Student::whereNull('user_id')->get();
        return view('pages.dashboard.admin.master-data.user.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'students' => $students,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|in:student,admin',
            'name' => 'nullable|required_if:role,admin',
            'student_id' => 'nullable|required_if:role,student|exists:students,id',
        ]);
        if ($validated['role'] === RoleEnum::STUDENT->value) {
            $student = Student::findOrFail($validated['student_id']);
            $validated['name'] = $student->name;
        }
        unset($validated['student_id']);
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        if ($validated['role'] === RoleEnum::STUDENT->value) {
            $student->update(['user_id' => $user->id]);
        }
        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'Berhasil membuat data pengguna.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('pages.dashboard.admin.master-data.user.show', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'user' => $user->loadCount('aspiration_feedbacks')->load('student'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $students = Student::whereNull('user_id')
            ->orWhere('user_id', $user->id)
            ->get();
        return view('pages.dashboard.admin.master-data.user.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'students' => $students,
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|max:255',
            'role' => 'required|in:student,admin',
            'name' => 'nullable|required_if:role,admin',
            'student_id' => 'nullable|required_if:role,student|exists:students,id',
        ]);
        if ($validated['role'] === RoleEnum::STUDENT->value) {
            $student = Student::findOrFail($validated['student_id']);
            $validated['name'] = $student->name;
        }
        unset($validated['student_id']);
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        $user->update($validated);
        Student::where('user_id', $user->id)->update(['user_id' => null]);
        if ($validated['role'] === RoleEnum::STUDENT->value) {
            $student->update(['user_id' => $user->id]);
        }
        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'Berhasil mengubah data pengguna.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->role === RoleEnum::STUDENT && $user->student) {
            $user->student->update([
                'user_id' => null
            ]);
        }
        $user->delete();
        return redirect()->route('dashboard.admin.master-data.users.index')->with('success', 'Berhasil menghapus data pengguna.');
    }
}
