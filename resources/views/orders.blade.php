<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Užsakymai</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


    <!-- styles -->
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">


</head>
<body>
<div class="flex-center position-ref full-height">

    <div class="content">
        <div class="title m-b-md">
            Užsakymai
        </div>
    <a href="/">Užsakymo forma</a>

        <div class="info">
            <p>Čia galite matyt visus užsakymus</p>
       @if(\Illuminate\Support\Facades\Session::has('success'))

            <p class="alert-success">Jūsų užsakymas sėkmingai pridėtas į duomenų bazę.</p>
            @endif

            <div class="container">
                @if(count($errors) > 0)
                    <ul class="list-group" >
                        @foreach($errors->all() as $error)
                            <li class="list-group-item text-danger">{{$error}}</li>

                        @endforeach
                    </ul>

                @endif

                <form action="/uzsakymai/search" method="get"  role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" id="q"  value="{{$q}}" name="q"
                           placeholder="Paieška"> <span class="input-group-btn" >
        <button type="submit" class="btn btn-default">
        <span class="glyphicon glyphicon-search"></span>
        </button>
        </span>
                </div>
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Vardas</th>
                        <th>Pavardė</th>
                        <th>Adresas</th>
                        <th>Miestas</th>
                        <th>E-mail</th>
                        <th>Skubus</th>
                        <th>Užsakymo data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <th>{{$order->name}}</th>
                        <th>{{$order->surname}}</th>
                        <th>{{$order->adress}}</th>
                        <th>{{$order->city}}</th>
                        <th>{{$order->email}}</th>
                        @if($order->is_fast == 'off')
                            <th>Ne</th>
                        @else
                            <th>Taip</th>

                        @endif
                        <th>{{$order->created_at->format('d-m-Y')}}</th>

                    </tr>

                        @endforeach
                </tbody>
                {{$orders->links()}}
            </table>

            <div align="left" class="table-bordered">
                Rodyti tik:
                <br>
                <a href={{route('uzsakymai.index', [ 'fast' => 'on' , 'sort-name' => request('sort-name'),
                 'sort-surname' => request('sort-surname') , 'sort-date' => request('sort-date'), 'sort-city' => request('sort-city'),  'q' => request('q')])}}>Skubius</a>

                <a href="{{route('uzsakymai.index', [ 'fast' => 'off', 'sort-name' => request('sort-name'),
                'sort-surname' => request('sort-surname'), 'sort-date' => request('sort-date'), 'sort-city' => request('sort-city'),  'q' => request('q')])}}">Neskubius</a>
                <br>
                <a  href="{{route('uzsakymai.index')}}">Rodyti viską</a>
            </div>
            <br>
            <div align="left" class="sorting">
                <table class="table-bordered">
                    <tr>
                        <td>Rikiuoti pagal vardą:</td>
                        <td><a  href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-name' => 'asc' , 'q' => request('q')])}}">Didėjančiai</a></td>
                        <td> <a href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-name' => 'desc',  'q' => request('q')])}}"> Mažėjančiai</a></td>
                    </tr>
                <tr>
                    <td>Rikiuoti pagal pavardę:</td>
                    <td><a  href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-surname' => 'asc', 'q' => request('q')])}}">Didėjančiai</a></td>
                    <td> <a href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-surname' => 'desc',  'q' => request('q')])}}"> Mažėjančiai</a></td>
                </tr>

                    <tr>
                        <td>Rikiuoti pagal sukūrimo datą:</td>
                        <td><a  href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-date' => 'asc',  'q' => request('q')])}}">Didėjančiai</a></td>
                        <td><a href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-date' => 'desc',  'q' => request('q')])}}"> Mažėjančiai</a></td>
                    </tr>
                    <tr>
                        <td>Rikiuoti miestą:</td>
                        <td><a  href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-city' => 'asc',  'q' => request('q')])}}">Didėjančiai</a></td>
                        <td><a href="{{route('uzsakymai.index', ['fast' => request('fast'), 'sort-city' => 'desc',  'q' => request('q')])}}"> Mažėjančiai</a></td>
                    </tr>

            </table>
            </div>

    </div>

</div>

</body>
</html>
