<?php

namespace App\Http\Controllers;

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
    public function raion(Request $request, $id)
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
}
