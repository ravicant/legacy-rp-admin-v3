<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware to check if user is a super admin on our game-servers.
 *
 * @package App\Http\Middleware
 */
class SuperAdminMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check for super admin status.
        if (!$this->isSuperAdmin($request)) {
            return backWith('error',
                'You must be a Super Admin to do that! Contact a higher-up if you were shown this error by mistake.'
            );
        }

        return $next($request);
    }

    /**
     * Checks if the user that sent request is staff.
     *
     * @param Request $request
     * @return bool
     */
    protected function isSuperAdmin(Request $request) : bool
    {
        $user = user();

        return $user && $user->isSuperAdmin();
    }

}
