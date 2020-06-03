<?php

namespace App\Http\Controllers;

use App\EcoCod;
use App\Http\Resources\Ecocod as EcocodResource;
use App\Http\Resources\Raion as RaionResource;
use App\Http\Resources\Iban as IbanResource;
use App\Iban;
use App\Locality;
use App\Http\Resources\Locality  as LocalityResource;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    /**
     * Update the authenticated user's API token.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function update(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return ['token' => $token];
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     *  (raion)  Intoarce toate localitatile dintrun Raion dupa id raion.
     */
    public function locality(Request $request, $id)
    {
        $loc = Locality::where('id', '=' , $id)->get();

        if (!$loc->first()->isRaion()) return 'Nu e raion';
            else {
                $next =  Locality::where('id', '>' , $id)->get();
                    foreach ($next as $item)
                    {
                        if($item->isRaion())
                            $next  =  $next->where('id','<', $item->id);
                    }
            }
        return  LocalityResource::collection($next);
    }

    public function raion()
    {
        $loc = Locality::all();

        $collect = collect([]);
        foreach ($loc as $item)
        {
            if($item->isRaion() ) {
                $collect->push($item);
            }
        }

//        dd($collect);
        return RaionResource::collection($collect);
    }

    public function iban(Request $request)
    {
        // exeemple of URL : api/iban?codeco=113230&raion=5050&locality=1212

        $codeco = $request->get('codeco');
        $raion = $request->get('raion');
        $locality = $request->get('locality');


        if( strlen($raion) == 4){
            $r = substr($raion, 0, 2);
        }
        else
            return response('Incorect raion: ' . $codeco . $raion . $locality ,200)
                ->header('Content-Type', 'text/plain');

        $iban =  Iban::where([
            'cod_eco' =>   $codeco,
            'cod_raion' => $r,
            'cod_local' => $locality
        ])->get();

        if ($iban->first() === null)
            return response('Nu a fost gasit un IBAN valid : ' . $codeco . $raion . $locality ,200)
                            ->header('Content-Type', 'text/plain');
        return  IbanResource::collection($iban);
    }

    public function ecocod()
    {
       return  EcocodResource::collection(EcoCod::all());
    }

    public function add_iban($iban)
    {

        return response('Iban a fost adaugat cu succes' . $iban ,200)
                            ->header('Content-Type', 'text/plain');
    }

    public function get_iban(Request $request)
    {
         $token =  $request->get('token');

        return response('Iban get' . $token,200)
            ->header('Content-Type', 'text/plain');
    }

    public function get_iban_local(Request $request)
    {
        $token =  $request->get('token');

        return response('Iban get' . $token,200)
            ->header('Content-Type', 'text/plain');
    }
}
