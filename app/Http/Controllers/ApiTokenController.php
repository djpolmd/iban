<?php

namespace App\Http\Controllers;

use App\EcoCod;

use App\Rules\Unique;
use App\Rules\Uppercase;
use App\Http\Resources\Ecocod as EcocodResource;
use App\Http\Resources\Raion as RaionResource;
use App\Http\Resources\Iban as IbanResource;
use App\Iban;
use App\Locality;
use App\Http\Resources\Locality  as LocalityResource;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

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

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
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

        return RaionResource::collection($collect);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
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

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function ecocod()
    {
       return  EcocodResource::collection(EcoCod::all());
    }

    public function add_iban(Request $request)
    {
        try   //Catch error to e.handler
        {
            $validator = Validator::make($request->all(), [
                'iban' => ['required',
                    'unique:ibans',
                    'max:24',
                    'min:24',
                    'starts_with:MD',
                    new Uppercase,
                    new Unique]
            ]);

            // Message Bag Parsing
            if ($validator->fails()) {
                $errors = (string)'';
                foreach ($validator->getMessageBag()->all() as $item) {
                    $errors = $errors . $item;
                }
                return
                    response('Incorect Iban format: ' . $errors, 422);
            }   // End MessageBag

            $iban = $request->get('iban');
            $codeco = substr($iban, 10, 6);
            $codlocal = substr($iban, 16, 4);

            if (Locality::all()->where('cod3', '=', $codlocal)->first() === null)
                return response('Incorecta  selectat localitatea', 422);
            if (EcoCod::all()->where('cod', '=', $codeco)->first() === null)
                return response('Incorect  selectat ecocod', 422);
            $cod_raion = Locality::where('cod3', '=', $codlocal)
                ->first()
                ->getIbanRaion();

            $iban_data = new Iban();
            // Daca exista acest Iban deja
            if ($iban_data->where([
                    'cod_eco' => $codeco,
                    'cod_local' => $codlocal,
                    'cod_raion' => $cod_raion
                ])->first() !== null) {
                return response('Acest Iban exista!', 422);
            }
            $iban_data->cod_eco = $codeco;
            $iban_data->cod_local = $codlocal;
            $iban_data->cod_raion = $cod_raion;
            $iban_data->iban = $iban;

            if ($iban_data->save())
                return
                    response('Iban a fost adaugat cu succes :' . $iban, 201)
                        ->header('Content-Type', 'text/plain');
            else response('A fost comisa greseala in momentul salvarii :' . $iban ,500)
                        ->header('Content-Type', 'text/plain');

        } catch (Exception $exception)
        {
            response('A fost comisa greseala :' . $exception ,500)
                ->header('Content-Type', 'text/plain');
        }

    }


    public function get_iban(Request $request)
    {
        $token  = $request->get('token');
         $ecocod = $request->get('ecocod');
         $raion  = substr($request->get('locality'), 0, 2);
         $locality = $request->get('locality');


         $iban =  Iban::where('cod_eco',   '=', $ecocod)
                      ->where('cod_local','=', $locality)
                      ->pluck('iban')
                      ->last();

        if ($iban === null)
            return response('Iban nu a fost gasit',404)
                ->header('Content-Type', 'application/json,');

        return response($iban,200)
                    ->header('Content-Type', 'application/json');
    }

    public function get_iban_id(Request $request)
    {
        $token  = $request->get('token');
        $ecocod = $request->get('ecocod');
        $raion  = substr($request->get('locality'), 0, 2);
        $locality = $request->get('locality');

        $iban_id =  Iban::where('cod_eco',   '=', $ecocod)
            ->where('cod_local','=', $locality)
            ->pluck('id')
            ->last();

        if ($iban_id === null)
            return response('Iban nu a fost gasit',404)
                ->header('Content-Type', 'application/json,');

        return response($iban_id,200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function get_iban_operator(Request $request)
    {
        $token    = $request->get('token');
        $ecocod   = $request->get('ecocod');
        $locality = $request->get('locality');

        $user  =  User::first();
        $user  =  $user->getUserByToken($token);

        $user_raion =  $user->first()
                    ->locality()
                    ->get('cod1')
                    ->pluck('cod1')
                    ->last();
        $raionloc  = Locality::where('cod3','=', $locality)
                    ->get('cod1')
                    ->pluck('cod1')
                    ->last();

        if ($user_raion !== $raionloc)

            return response('Nu coincide permisiunea pe raion' . $user_raion . $raionloc,401)
                    ->header('Content-Type', 'application/json,');

        $iban =  Iban::where('cod_eco', '=', $ecocod)
            ->where('cod_local','=', $locality)
            ->pluck('iban')
            ->last();

        if ($iban === null)
            return response('Iban nu a fost gasit',404)
                ->header('Content-Type', 'application/json,');

        return response($iban,200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function raion_operator(Request $request)
    {
        $token =  $request->get('token');
        $user  =  User::first();
        $user  =  $user->getUserByToken($token);
        $raion =  $user->first()
                        ->locality()
                        ->pluck('cod1')
                        ->last();
        $query = Locality::where('cod3','=', $raion)
                        ->get('name')
                        ->pluck('name')
                        ->last();

        $name = $raion . ' - ' . $query;

        return response($name,200)
            ->header('Content-Type', 'application/json');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function locality_operator(Request $request)
    {
        $token =  $request->get('token');
        $user  =  User::first();
        $user  =  $user->getUserByToken($token);
        $raion =  $user->first()
            ->locality();
        $id = $raion->pluck('id')->last();

            $next =  Locality::where('id', '>' , $id)->get();
            foreach ($next as $item)
            {
                if($item->isRaion())
                    $next  =  $next->where('id','<', $item->id);
            }

        return  LocalityResource::collection($next);
    }


    /**
     * @param Request $request
     * @param $iban_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function put_iban(Request $request, $iban_id)
    {
        $validator = Validator::make($request->all(),[
            'iban' => ['required',
                'unique:ibans',
                'max:24',
                'min:24',
                'starts_with:MD',
                new Uppercase,
                new Unique ]
        ]);
        // Message Bag Parsing
        if($validator->fails()) {
            $errors = (string)'';
            foreach($validator->getMessageBag()->all() as $item)
            {
                $errors = $errors . $item;
            }
            return
                response('Incorect Iban  format: ' . $errors , 422);
        }   // End MessageBag

        $iban = $request->get('iban');

        $codeco = substr($iban,10, 6);
        $codlocal = substr($iban,16,4);


        if( Locality::all()->where('cod3','=', $codlocal)->first() === null)
            return response('Incorecta  selectat localitatea',422);
        if( EcoCod::all()->where('cod','=', $codeco)->first() === null)
            return response('Incorect  selectat ecocod',422);


        $cod_raion = Locality::where('cod3' ,'=', $codlocal)
            ->first()
            ->getIbanRaion();

        if (Iban::where('id','=', $iban_id)->update([
            'cod_eco' => $codeco,
            'cod_local' => $codlocal,
            'cod_raion' => $cod_raion,
            'iban' => $iban,
        ]))
            return
                response('Iban a fost modificat cu succeses.  :' . $iban ,200)
                    ->header('Content-Type', 'text/plain');

        else response('A fost comisa greseala in momentul modificarii :' . $iban ,405)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * @param Request $request
     * @param $iban_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function delete_iban(Request $request, $iban_id)
    {
        $token =  $request->get('token');

       if(Iban::find($iban_id)->delete())

        return response('Iban a fost șters!' ,200)
                ->header('Content-Type', 'text/plain');
       else
           return response('Iban - nu poate fi procesat!' ,422)
                ->header('Content-Type', 'text/plain');
    }
}
