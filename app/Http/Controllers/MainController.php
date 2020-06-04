<?php

namespace App\Http\Controllers;


use App\EcoCod;
use App\Locality;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
   public function index(Request $request)
   {
       $users = User::all();

       $token = Auth()->user()->getToken();

       return view('index')
                 ->withUsers($users)
                 ->withToken($token);
   }
   //    From route IBAN

    /**
     * @param Request $request
     * @return mixed
     */
   public  function iban(Request $request)
   {
       return view('form');
   }
}
