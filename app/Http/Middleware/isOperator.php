<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class isOperator
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
        $user = new User();
        $token = $request->get('token');

        if(isAdmin::getUserId($token) == null)
            return
                response('Wrong token.', 401);

        $userRole = $user->where('id', $this->getUserId($token))
            ->first()
            ->getUserRole();

        // verificam daca utilizator este operator

        $isOperator = ($userRole == "operator_raion");

        // in cazul cind nu este operator

        if( !$isOperator)
        {
            if ($request->ajax()) {
                return
                    response('Unauthorized.', 401);
            } else {
                return redirect()->back();
                //todo posibil sa nu lucreze linkul...
            }
        }

        return $next($request);
    }
}
