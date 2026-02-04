<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\RoleEnum;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspiration $aspiration)
    {
        //
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
