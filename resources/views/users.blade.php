
@extends('layouts.admin')

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

                        <ul>
                            <li class="form_li">
                                <a style="display: inline; padding-left: 445px;" href="{{ mix('csv/iban_2020.csv') }}"> Descarca registru
                                    <div class="csv_image">
                                    </div>
                                </a>
                            </li>
                            {{--                             Nume   --}}
                            <li class="form_li">
                                <label for="cod_anul">Nume:</label>
                                <input name="nume" value="" placeholder="Nume">
                            </li>
                            {{--                              Prenume  --}}
                            <li class="form_li">
                                <label for="cod_eco">Prenume:</label>
                                <input name="prenume" placeholder="Prenume">
                            </li>
                            {{--                               Raion --}}
                            <li class="form_li">
                                <label>Raionul:</label>
                                <v-select
                                    v-on:input="getOptions()"
                                    v-model="selectedRaion"
                                    :options="raionOptions"
                                    v-bind:value="selectedRaion"
                                    label="name"
                                ></v-select>
                            </li>
                            {{--                                Localiatea--}}
                            <li class="form_li">
                                <label for="cod_loc">Localitatea:</label>

                                <v-select label="name"  v-model="selectedLocality"
                                          :on-search="getOptions"
                                          :options="localityOptions"
                                >
                                </v-select>
                                <br>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

