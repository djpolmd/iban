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

    /**
     * @param Request $request
     * @return mixed
     */
   public  function iban(Request $request)
   {
       $EcoCodModel = EcoCod::all();
       $LocModel = Locality::all();

       $id = 0;
       $dropbox1 = (string)'';
       $dropbox2 = (string)'';
       $dropbox3 = (string)'';

       //Format Json output : { label: 'Canada', code: 'ca' }

           foreach($EcoCodModel as $obj)
           {
               ++$id;
               $dropbox1 = $dropbox1 . '{ label :' . $obj->getEcoCod() . ' , code : ' . "'" . $id . "'},"  ;
           }
         $dropbox1 = ' [ ' . $dropbox1 . ' ] ';
//       dd($dropbox1);

       foreach($LocModel as $obj)
       {
           ++$id;
          if($obj->isRaion())
              $dropbox2 = $dropbox2 . '{ label :' . $obj->getRaion() . ' , code : ' . "'" . $id . "'},"  ;
       }
       $dropbox2 = ' [ ' . $dropbox2 . ' ] ';

       $id = 0;

       foreach($LocModel as $obj)
       {
           ++$id;
           if(!$obj->isRaion())
               $dropbox3 = $dropbox3 . '{ label :' . $obj->getSector() . ' , code : ' . "'" . $id . "'},"  ;
       }
       $dropbox3 = ' [ ' . $dropbox3 . ' ] ';

//        dd($dropbox2);
       return view('form')->withEcocod($dropbox1)
                                ->withRaion($dropbox2)
                                ->withLocalitatea($dropbox3);
   }
}
