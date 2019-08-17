<?php

namespace App\Core\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|void
     */
    protected function redirectTo($request)
    {
        throw UnauthorizedException::forPermissions([$request->getUri()]);
    }
}
