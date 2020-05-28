<?php

namespace App\Http\Controllers;


use App\EcoCod;
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
   //    From route IBAN
   public  function iban(Request $request)
   {
       $ecocod   = EcoCod::all()->pluck('name', 'id');
       $collection = collect([]);
        $id = 0;
        $a = array();

       foreach($ecocod as $item)
            {
              ++$id;
              $collection->put( 'id :' . $id, $item)->toArray();
              $a[] = ['id :' . $id  => $item ];
            }

       $eco = EcoCod::all();
       $dropbox = (string)'';

       foreach($eco as $obj)
       {
           ++$id;
           $dropbox = $dropbox  .  '{ id :' . (string)$id
                                .' , ' .'name :' . $obj->getEcoCod() . ' },' ;
       }

//       echo json_encode($dropbox, JSON_FORCE_OBJECT);
//        echo $dropbox;
//       $a =   $collection;
      $coll = json_encode($a,   JSON_FORCE_OBJECT);

//      dd($coll);

            return view('form')->withEcocod($dropbox);
   }
}
