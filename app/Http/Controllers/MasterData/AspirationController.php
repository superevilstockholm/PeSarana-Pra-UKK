<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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
        $query = Aspiration::query()->with(['student', 'category', 'aspiration_images']);

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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'aspiration_images' => 'nullable|array',
            'aspiration_images.*' => 'image|mimes:jpg,png,jpeg,webp|max:4096'
        ]);
        $validated['student_id'] = $user->student->id;
        $validated['status'] = AspirationStatusEnum::PENDING;
        $aspiration = Aspiration::create($validated);
        if ($request->hasFile('aspiration_images')) {
            foreach ($request->file('aspiration_images') as $image) {
                $path = $image->store('aspiration_images', 'public');
                $aspiration->aspiration_images()->create([
                    'image_path' => $path,
                ]);
            }
        }
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
            'aspiration' => $aspiration->load(['student', 'category', 'aspiration_images', 'aspiration_feedbacks']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspiration $aspiration): View
    {
        $categories = Category::all();
        return view('pages.dashboard.student.aspiration.edit', [
            'meta' => [
                'sidebarItems' => studentSidebarItems(),
            ],
            'categories' => $categories,
            'aspiration' => $aspiration->load(['student', 'category', 'aspiration_images']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspiration $aspiration): RedirectResponse
    {
        $user = $request->user();
        if (!$user->student) {
            return redirect()->route('dashboard.student.aspirations.index')->withErrors('Data siswa tidak ditemukan.');
        }
        if ($aspiration->status === AspirationStatusEnum::COMPLETED) {
            return redirect()->route('dashboard.student.aspirations.index')->withErrors('Tidak dapat mengubah aspirasi yang sudah selesai.');
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'aspiration_images' => 'nullable|array',
            'aspiration_images.*' => 'image|mimes:jpg,png,jpeg,webp|max:4096',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:aspiration_images,id',
        ]);
        $aspiration->update($validated);
        if (!empty($validated['deleted_images'])) {
            $imagesToDelete = $aspiration->aspiration_images()
                ->whereIn('id', $validated['deleted_images'])
                ->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
        if ($request->hasFile('aspiration_images')) {
            foreach ($request->file('aspiration_images') as $image) {
                $path = $image->store('aspiration_images', 'public');
                $aspiration->aspiration_images()->create([
                    'image_path' => $path,
                ]);
            }
        }
        return redirect()->route('dashboard.student.aspirations.index')->with('success', 'Berhasil memperbarui aspirasi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspiration $aspiration, Request $request): RedirectResponse
    {
        $user = $request->user()->load('student');
        if ($user->role === RoleEnum::STUDENT && $aspiration->student_id !== $user->student->id) {
            abort(403, 'Forbidden');
        }
        $aspiration->delete();
        return redirect()->route($user->role === RoleEnum::ADMIN
            ? 'dashboard.admin.master-data.aspirations.index'
            : 'dashboard.student.aspirations.index')->with('success', 'Berhasil menghapus aspirasi.');
    }
}
