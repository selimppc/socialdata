<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ApiCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $field = filter_var(Input::get('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $attempt = Auth::attempt([
            $field => Input::get('email'),
            'password' => Input::get('password'),
        ]);
        if($attempt){
            return $next($request);
        }
        else{
            return response('Unauthorized.', 401);
        }

    }
}
