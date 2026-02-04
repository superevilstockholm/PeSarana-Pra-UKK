<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Category;
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\RoleEnum;
use App\Enums\AspirationStatusEnum;

class AspirationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user()->load('student');
        $limit = $request->query('limit', 10);
        $query = Aspiration::query()->with(['student', 'category']);

        // Scoped student for student user
        if ($user->role === RoleEnum::STUDENT && $user->student) {
            $query->where('student_id', $user->student->id);
        }

        $aspirations = $limit === 'all'
            ? $query->get()
            : $query->paginate((int) $limit)
                ->appends($request->except('page'));

        return view($user->role === RoleEnum::ADMIN
            ? 'pages.dashboard.admin.master-data.aspiration.index'
            : 'pages.dashboard.student.aspiration.index', [
            'meta' => [
                'sidebarItems' => $user->role === RoleEnum::ADMIN
                    ? adminSidebarItems()
                    : studentSidebarItems(),
            ],
            'aspirations' => $aspirations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('pages.dashboard.student.aspiration.create', [
            'meta' => [
                'sidebarItems' => studentSidebarItems(),
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user()->load('student');
        if (!$user->student) {
            return redirect()->route('dashboard.student.aspirations.index')->withErrors('Data siswa tidak ditemukan.');
        }
        $validated = $request->validate([
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id'
        ]);
        if ($request->hasFile('cover_image')) {
            $validated['cover_image_path'] = $request->file('cover_image')->store('aspirations', 'public');
        }
        unset($validated['cover_image']);
        $validated['student_id'] = $user->student->id;
        $validated['status'] = AspirationStatusEnum::PENDING;
        Aspiration::create($validated);
        return redirect()->route('dashboard.student.aspirations.index')->with('success', 'Berhasil membuat aspirasi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspiration $aspiration, Request $request): View
    {
        $user = $request->user()->load('student');
        if ($user->role === RoleEnum::STUDENT && $aspiration->student_id !== $user->student->id) {
            abort(403, 'Forbidden');
        }
        return view($user->role === RoleEnum::ADMIN
            ? 'pages.dashboard.admin.master-data.aspiration.show'
            : 'pages.dashboard.student.aspiration.show', [
            'meta' => [
                'sidebarItems' => $user->role === RoleEnum::ADMIN
                    ? adminSidebarItems()
                    : studentSidebarItems(),
            ],
            'aspiration' => $aspiration->load(['student', 'category'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspiration $aspiration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspiration $aspiration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspiration $aspiration)
    {
        //
    }
}
