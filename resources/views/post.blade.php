
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
                            <a href="{{url('/')}}"><br> Spre -> Lista utilizatorilor  </a>
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
                                <v-select
                                    my-props="test test"
                                    :options="{!! $data !!}"
                                ></v-select>
                            </li>
                            {{--                              EcoCod  --}}
                            <li class="form_li">
                                <label for="cod_eco">Codul Eco:</label>
                                <v-select v-model="selectedEcocod"
                                          :options="optionsEcocod"

                                          label="name"
                                ></v-select>

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

                            <div class="container4">
                                <button v-on:click="getIban()"
                                        style="display: inline;display: block;margin-left: auto;margin-right: auto;"
                                        {{--  @click="checkIban()"--}}
                                        name="submit"
                                        class="submit"
                                        type="submit">
                                    Afiseaza codul IBAN
                                </button>

                            </div>

                            <li class="form_li">
                                <input class="kms"
                                       v-model:value="IbanResponce"
                                       name="Iban"
                                >
                            </li>
                            <li class="form_li">
                                <button v-on:click="postIban()" style="display: inline;display: block;margin-left: auto;margin-right: auto;"
                                        name="submit"
                                        class="submit"
                                        type="submit">
                                    Introduce Iban
                                </button>
                                   <br>
                                <button v-on:click="deleteIban()" style="background-color:red; inline;display: block;margin-left: auto;margin-right: auto;"
                                        name="submit"
                                        class="submit"
                                        type="submit">
                                    Elimina Iban
                                </button>
                            </li>
                                <input type="checkbox"
                                       id="update"
                                       name="update"
                                       v-model="checkEd"
                                >
                            <label> Modifică Iban existent </label>
                            <br>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

