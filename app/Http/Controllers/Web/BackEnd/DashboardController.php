<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Enums\PostStatus;
use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\DashboardService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_DASHBOARD->value);

        $range = request('range', '7d'); // default ke 7d kalau tidak ada

        if (!preg_match('/^(\d+)d$/', $range, $matches) || (int) $matches[1] < 7 || (int) $matches[1] > 90) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['range' => 'The range must be in the format "Nd" and between 7d and 90d.']);
        }

        $dashboard = app(DashboardService::class)->getDashboardData(auth()->user(), $range);

        return view('pages.dashboard.index', [
            'dashboard' => $dashboard,
        ]);
    }
}
