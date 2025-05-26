<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return [
            'total_companies' => Company::count(),
            'total_users' => User::count(),
            'new_users' => User::query()->where('created_at', '>=', now()->subDays(30))->count(),
        ];
    }
}