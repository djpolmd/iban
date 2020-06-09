<?php

namespace App\Http\Controllers;


use App\EcoCod;
use App\Locality;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JavaScript;


class MainController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
   public function index(Request $request)
   {
       $users = User::all();

       return view('index')->withUsers($users);
   }

    /**
     * @param Request $request
     * @return mixed
     */
   public  function iban(Request $request)
   {
       $users = User::all();

       $token = Auth()->user()->getToken();

       JavaScript::put([
           'api_token' => $token
       ]);

       return view('form');
   }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
   public function post_form()
   {
       $user = Auth()->user();

       if ( $user->getUserRole() !== 'admin')
             return redirect('home',302);

       $token = $user->getToken();

       JavaScript::put([
           'api_token' => $token
       ]);

       return view('post');
   }
}
