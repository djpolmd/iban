<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Cache;
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
        $token = $request->get('token');
    //   test data: /api/get_iban?token=06a4f88B6ig21285r2VUKjT05S3bxTMUNMwy0ad5ZlZkAWj5Vz34Rzev6bBG
        if (Cache::has('user.admin'))
        {
            $value = Cache::get('user.admin');
            if ($value === $token)
                return $next($request);
        }

        // TODO hardcoded query for user search  can be transfer to elastic.

        $user = new User();

        $user_id = $user->getUserId($token);

        if($user_id == null) {
            $user->delete();
            return response('Wrong token.', 401);
        }

        $userRole = $user->where('id', $user_id)->first()->getUserRole();

        // Verificam daca utilizator este admin

        $isAdmin = ($userRole == "admin");

        if($isAdmin){
            Cache::add('user.admin',$token , 30);
        }

        // In cazul cind nu este admin

        if( !$isAdmin )
        {
            if ($request->ajax()) {
                return
                    response('Unauthorized.', 401);
                } else {
                dd($isAdmin);
                    return redirect()->back()->withErrors('Error',200);
                    //todo posibil sa nu lucreze linkul...
                }
        }

        $user->delete();
        return $next($request);
    }
}
