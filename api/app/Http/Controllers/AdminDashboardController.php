<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return [
            'total_users' => User::count(),
            // 'total_organisations' => Organisation::count(),
            // 'new_users' => User::query()->where('created_at', '>=', now()->subDays(30))->count(),
            // 'new_organisations' => Organisation::query()->where('created_at', '>=', now()->subDays(30))->count(),
        ];
    }
}