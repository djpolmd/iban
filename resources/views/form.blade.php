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

                             @php($data = " { id: 1, name: 'Option 1' },
                                            { id: 2, name: 'Option 2' },
                                            { id: 3, name: 'Option 3' },
                                    " )

                               <a style="display: inline; padding-left: 25px;" href="{{ mix('csv/iban_2020.csv') }}"> Descarca registru
                                   <div class="csv_image">
                                   </div>
                               </a>


                            <div class=".select2">
                                <Dropdown
                                    :options="[ {!! $ecocod !!} ]"
                                    v-on:selected="validateSelection"
                                    v-on:filter="getDropdownValues"
                                    :disabled="false"
                                    :maxItem="500"
                                    placeholder="Selectați vă rog opționea">
                                 </Dropdown>
                            </div>

                            </div>
                        <div class="container4">
                            <button  style="display: inline;"  name="submit" class="submit" type="submit">
                                Afiseaza codul IBAN
                            </button>
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection
