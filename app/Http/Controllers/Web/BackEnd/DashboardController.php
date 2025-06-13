<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Enums\PostStatus;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::READ_DASHBOARD->value);

        $range = request('range', '7d'); // bisa '7d', '30d', '2m', dst

        $dashboard = app(DashboardService::class)->getDashboardData(auth()->user(), $range);

        return view('pages.dashboard.index', [
            'dashboard' => $dashboard,
        ]);
    }
}
