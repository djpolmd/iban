@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Forma utilizatorului :
                       @if( Auth()->check())
                           @php($username =  Auth()->user()->nume)
                               {{ Auth()->user()->getUserRole()  }}
                               <br> Permisiuni : &ensp;
                                {{ Auth()->user()->getUserRolePermissions() }}
                                {{ session()->put('status', 'Bine ati venit ' . $username .  '  !!!') }}
                </div>

                        @else
                            {{ session()->put('status', 'Nu aveti permisiune sa acessati forma!!!') }}

                            <a href="{{ url('login') }}"> Please log-in </a>
                            <a href="{{ url('register') }}"> or  Please register </a>
                        @endif
                                <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                             @php($data = " [{ label: '2017', code: '1' },
                                            { label: '2018', code: '2' },
                                            { label: '2019', code: '3' },
                                            { label: '2020', code: '4' }]
                                    " )
                            <ul>
{{--                          CSV IMAGE      --}}
                                  <li class="form_li">
                                       <a style="display: inline; padding-left: 445px;" href="{{ mix('csv/iban_2020.csv') }}"> Descarca registru
                                           <div class="csv_image">
                                       </div>
                                       </a>
                                  </li>
{{--                             Anul   --}}
                                    <li class="form_li">
                                        <label for="cod_anul">Anul:</label>
                                        <v-select  :options="{!! $data !!}"  ></v-select>
                                    </li>
{{--                              EcoCod  --}}
                                <li class="form_li">
                                    <label for="cod_eco">Codul Eco:</label>
                                    <v-select
                                        :options="{!! $ecocod !!}"
                                    ></v-select>
                                </li>
{{--                               Raion --}}
                                <li class="form_li">
                                    <label>Raionul:</label>
                                    <v-select
                                        :options="{!! $raion !!}"
                                    ></v-select>
                                </li>
{{--                                Localiatea--}}
                                <li class="form_li">
                                    <label for="cod_loc">Localitatea:</label>

                                    <v-select
                                        :on-search="getOptions"
                                        :options="{!! $localitatea !!}"
                                        v-model="selected"
                                    ></v-select>

                                    <br>
                                    <select v-model="checkedRaion">
                                        <option>Item1 </option>
                                        <option>Item2 </option>
                                    </select>
                                </li>
                            </ul>
                            </div>
                        <div class="container4">
                            <button  style="display: inline;display: block;margin-left: auto;margin-right: auto;"  name="submit" class="submit" type="submit">
                                Afiseaza codul IBAN
                            </button>
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection

