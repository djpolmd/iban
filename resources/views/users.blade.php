
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

                                @if(session('errors') ?? true)
                                    <div class="alert alert-danger" role="alert">
                                        @php($mess  = session('errors') )
                                        {{ $mess }}
                                    </div>
                                @endif
                            </div>
                        @endif

                        <form  action="/add_user?token={{ Auth()->user()->getToken() }}" method="POST">
                            @csrf
                            <ul>
                            <li class="form_li">
                                <a style="display: inline; padding-left: 445px;" href="{{ mix('csv/iban_2020.csv') }}"> Descarca registru
                                    <div class="csv_image">
                                    </div>
                                </a>
                            </li>
                            {{--                             Nume   --}}
                            <li class="form_li">
                                <div class="form-group">
                                    <label for="inputname">Nume:</label>
                                    <input class="form-control" id="inputname" name="nume"  placeholder="Nume" type="text">
                                </div>
                            </li>
                                <li class="form_li">
                                    <div class="form-group">
                                        <label for="inputname">Prenume:</label>
                                        <input class="form-control" id="inputfamily" name="prenume"  placeholder="Prenume" type="text">
                                    </div>
                                </li>

                            {{--                               Raion --}}
                            <li class="form_li">
                                <div class="form-group">
                                    <label>Raionul:</label>
                                    <v-select
                                        v-on:input="getOptions()"
                                        v-model="selectedRaion"
                                        :options="raionOptions"
                                        v-bind:value="selectedRaion"
                                        id="raion"
                                        name="raion"
                                        label="name"
                                    ></v-select>
                                    <input type="hidden" name="raion" id="raion" :value="selectedRaion.id">
                                </div>
                            </li>
                            {{--                                Localiatea--}}
                            <li class="form_li">
                                <div class="form-group">
                                    <label for="locality">Localitatea:</label>
                                    <v-select label="name"  v-model="selectedLocality"
                                              :value="selectedLocality"
                                              :on-search="getOptions"
                                              :options="localityOptions"
                                              name="locality"
                                              id="select1"
                                    >
                                    </v-select>

                                    <input type="hidden" name="locality" id="locality" :value="selectedLocality.id">
                                </div>
                            </li>

                            <li class="form_li">
                                <div class="form-group">
                                    <label for="roles"> Rolul: </label>
                                    <select class="form-control" id="roles" name="roles">
                                        <option value="1">admin</option>
                                        <option value="2">operator</option>
                                        <option value="3">operator_raion</option>
                                    </select>

                                </div>
                            </li>

                            <li class="form_li">
                                <div class="form-group">
                                    <label for="api_token"> Api Token: </label>
                                    <input  class="form-control" name="api_token"  id="api_token" placeholder="Autogenerate">
                                </div>
                            </li>

                            <li class="form_li">
                                <div class="form-group">
                                    <label>@mail </label>
                                    <input class="form-control" name="email" name="email" id="email" placeholder="email">
                                </div>
                            </li>

                            <li class="form_li">
                                <div class="form-group">
                                    <label>Parola </label>
                                    <input class="form-control" type="password" name="password" id="password" placeholder="password">
                                </div>
                            </li>

                            <li class="form_li">
                                <div class="form-group">
                                    <button class="submit" name="submit" > Salva </button>
                                </div>
                            </li>

                        </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

