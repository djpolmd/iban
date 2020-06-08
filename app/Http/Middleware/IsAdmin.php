<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class isAdmin
{
    /**
     * @return mixed
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    //   test data: /api/get_iban?token=06a4f88B6ig21285r2VUKjT05S3bxTMUNMwy0ad5ZlZkAWj5Vz34Rzev6bBG

        $user = new User();
        $token = $request->get('token');

        if($user->getUserId($token) == null)
              return response('Wrong token.', 401);

        $userRole = $user->where('id', $user->getUserId($token))->first()->getUserRole();

        // Verificam daca utilizator este admin

        $isAdmin = ($userRole == "admin");

        // In cazul cind nu este admin

        if( !$isAdmin )
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
