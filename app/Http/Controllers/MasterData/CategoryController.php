<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\MasterData\Category;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $limit = $request->query('limit', 10);
        $query = Category::query()->withCount('aspirations');
        $categories = $limit === 'all'
            ? $query->get()
            : $query->paginate((int) $limit)
                ->appends($request->except('page'));
        return view('pages.dashboard.admin.master-data.category.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.dashboard.admin.master-data.category.create', [
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
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);
        Category::create($validated);
        return redirect()->route('dashboard.admin.master-data.categories.index')->with('success', 'Berhasil membuat data kategori');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): View
    {
        return view('pages.dashboard.admin.master-data.category.edit', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);
        $category->update($validated);
        return redirect()->route('dashboard.admin.master-data.categories.index')->with('success', 'Berhasil mengubah data kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
            return redirect()->route('dashboard.admin.master-data.categories.index')->with('success', 'Berhasil menghapus data kategori');
        } catch (Throwable $e) {
            return redirect()->route('dashboard.admin.master-data.categories.index')->withErrors($e->getMessage());
        }
    }
}
