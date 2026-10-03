<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('admin.dashboard', [
            'today' => now()->locale('id')->isoFormat('dddd, D MMMM YYYY'),
        ]);
    }
}
