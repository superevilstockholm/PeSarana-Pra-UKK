<?php

namespace App\Http\Controllers\MasterData;

use Throwable;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Classroom;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $limit = $request->query('limit', 10);
        $query = Classroom::query()->withCount('students');
        $classrooms = $limit === 'all'
            ? $query->get()
            : $query->paginate((int) $limit)
                ->appends($request->except('page'));
        return view('pages.dashboard.admin.master-data.classroom.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.dashboard.admin.master-data.classroom.create', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name',
            'description' => 'nullable|string',
        ]);
        Classroom::create($validated);
        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Berhasil membuat data kelas');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom): View
    {
        return view('pages.dashboard.admin.master-data.classroom.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'classroom' => $classroom,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classrooms,name,' . $classroom->id,
            'description' => 'nullable|string',
        ]);
        $classroom->update($validated);
        return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Berhasil mengubah data kelas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom): RedirectResponse
    {
        try {
            $classroom->delete();
            return redirect()->route('dashboard.admin.master-data.classrooms.index')->with('success', 'Berhasil menghapus data kelas');
        } catch (Throwable $e) {
            return redirect()->route('dashboard.admin.master-data.classrooms.index')->withErrors($e->getMessage());
        }
    }
}
