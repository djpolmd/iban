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
                                    <v-select v-model="selectedEcocod"
                                        :options="optionsEcocod"

                                        label="name"
                                    ></v-select>
                                   selectedRaion : @{{ getIdEcocod()  }}

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
                                    >

                                    </v-select>
                                   v-Model selectedRaion : @{{ getIdRaion() }}
                                </li>
{{--                                Localiatea--}}
                                <li class="form_li">
                                    <label for="cod_loc">Localitatea:</label>

                                    <v-select label="name"  v-model="selectedLocality"
                                        :on-search="getOptions"
                                        :options="localityOptions"
                                    >
                                    </v-select>
                                     localityOptions : @{{ getIdLocality() }}
                                    <br>

                                </li>

                        <div class="container4">
                             <button v-on:click="getIban()" style="display: inline;display: block;margin-left: auto;margin-right: auto;"
                              {{--  @click="checkIban()"--}}
                                     name="submit"
                                     class="submit"
                                     type="submit">
                                Afiseaza codul IBAN
                            </button>

                        </div>
                           <li class="form_li">
                               <div class="vs__selected-options">
                                {{--  <label> IBAN :  </label>  --}}
                                    <input  v-model="IbanOptions"
                                            v-if="ifVisible"
                                            class="kms">
                                   <alert-box v-if="alertBox">
                                       Ceva nue e in regula ...
                                   </alert-box>
                               </div>

                           </li>
                        </ul>
                    </div>
                    </div>
        </div>
    </div>
</div>
@endsection

