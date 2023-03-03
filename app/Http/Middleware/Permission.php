<?php

namespace App\Http\Middleware;

use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    protected $routes = [
        'users.login' => 1,
        'users.details' => 1,
        'users.create' => 1,
        'users.update' => 1,
        'users.delete' => 1,
        'users.index' => 1,
        'projects.index' => 2,
        'projects.create' => 2,
        'projects.update' => 2,
        'projects.delete' => 2,
        'projects.details' => 2,
        'tasks.create' => 3,
        'tasks.index' => 4,
        'tasks.update' => 5,
        'tasks.details' => 4,
    ];




    protected $route;
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function handle(Request $request, Closure $next)
    {
        // dump($this->routes[$this->route->getName()]);
        // dd($this->route->getName());
        $role_id = Auth::user()->role_id;
        $permission  = RolePermission::where('role_id', $role_id)->pluck('module_id')->toArray();

        if (in_array($role_id, $permission)) {

            return $next($request);
        } else {
            return 'User not Authorize';
        }
    }
}
