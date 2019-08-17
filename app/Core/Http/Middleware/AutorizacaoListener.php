<?php

namespace App\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AutorizacaoListener
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $permission = DB::table('permissions as p')
            ->select('p.id')
            ->join('role_has_permissions as rhp', 'rhp.permission_id', '=', 'p.id')
            ->join('roles as r', 'rhp.role_id', '=', 'r.id')
            ->where('p.name', '=', $request->route()->getAction()['controller'])
            ->whereIn('r.name', $user->getRoleNames())
            ->get();
        if ($permission->count() === 0) {
            throw UnauthorizedException::forPermissions([$request->getUri()]);
        }
        return $next($request);
    }
}
