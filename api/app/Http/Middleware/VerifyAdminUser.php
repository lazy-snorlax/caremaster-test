<?php

namespace App\Http\Middleware;

use App\Support\Enums\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VerifyAdminUser
{
    public function handle(Request $request, $next) 
    {
        if ($request->user()->isNotA(Role::Admin->value)) {
            throw new BadRequestHttpException('Admin role not assigned.');
        }
        return $next($request);
    }
}