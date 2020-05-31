<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IBAN Generator</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            @php( $local = '')

            <div class="content">
                <div class="container-fluid">
                    Count users:
                    {{ $users->count() }}
                    <br>
                   <b> Lista de utilizatori: </b>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope=""> ID :</th>
                            <th scope="col">Nume :</th>
                            <th scope="col">Prenume :</th>
                            <th scope="col">Localitatea :</th>
                            <th scope="col">Email :</th>
                        </tr>
                        </thead>
                    <tbody>

                    @foreach( $users as $user )
                        <tr>
                            <th scope="row">{{$user->id }}</th>
                            <td> {{ $user->nume }} </td>
                            <td> {{ $user->prenume }} </td>
                            <td> {{ $user->locality()->get('name')->pluck('name')->last() }} </td>
                            <td> {{ $user->email }}</td>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
