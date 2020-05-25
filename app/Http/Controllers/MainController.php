<?php

namespace App\Http\Controllers;


use App\Locality;
use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
   public function index(Request $request)
   {
       $users = User::all();

            $localities = Locality::all();


       return view('index')
                 ->withUsers($users)
                 ->withLocalities($localities);
   }
}
