<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Ninja
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$this->auth->check())
        {
            return redirect('/')->with('warn', 'You have to be logged in to do that.');
        }

        $user = $this->auth->user();

        if ($user->role === 'ninja')
        {
            return $next($request);
        } else {
            return redirect('/')->with('warn', 'You have to be a Ninja to do that.');
        }
    }
}