<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

// Models
use App\Models\User;
use App\Models\MasterData\Student;
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\RoleEnum;
use App\Enums\AspirationStatusEnum;

class DashboardController extends Controller
{
    public function admin(): View
    {
        $students_count = Student::count();

        $student_users_count = User::where('role', RoleEnum::STUDENT)->count();
        $admin_users_count = User::where('role', RoleEnum::ADMIN)->count();

        $aspirations_count = Aspiration::count();
        $pending_aspirations_count = Aspiration::where('status', AspirationStatusEnum::PENDING)->count();
        $on_going_aspirations_count = Aspiration::where('status', AspirationStatusEnum::ON_GOING)->count();
        $completed_aspirations_count = Aspiration::where('status', AspirationStatusEnum::COMPLETED)->count();
        $rejected_aspirations_count = Aspiration::where('status', AspirationStatusEnum::REJECTED)->count();

        $stats = [
            'students_count' => $students_count,
            'student_users_count' => $student_users_count,
            'admin_users_count' => $admin_users_count,
            'aspirations_count' => $aspirations_count,
            'pending_aspirations_count' => $pending_aspirations_count,
            'completed_aspirations_count' => $completed_aspirations_count,
            'on_going_aspirations_count' => $on_going_aspirations_count,
            'rejected_aspirations_count' => $rejected_aspirations_count,
        ];
        return view('pages.dashboard.admin.index', [
            'meta' => [
                'sidebarItems' => adminSidebarItems(),
            ],
            'stats' => $stats,
        ]);
    }

    public function student(): View
    {
        return view('pages.dashboard.student.index', [
            'meta' => [
                'sidebarItems' => studentSidebarItems(),
            ]
        ]);
    }
}
