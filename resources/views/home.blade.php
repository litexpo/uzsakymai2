<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Užsakymas</title>

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
           Paslaugų užsakymas
        </div>

        <div class="info">
            <p class="pristatymas">Norėdami užsisakyti mūsų paslaugas, užpildykite žemiau esančią formą.
                                   Jeigu jūsų užsakymas yra skubus, pažymėkite tai anketoje, tačiau jum
                                   tai kainuos daugiau.
            </p>
            <a href="/uzsakymai">Užsakymai</a>
        </div>

        <div class="container">
            @if(count($errors) > 0)
                <ul class="list-group" >
                    @foreach($errors->all() as $error)
                        <li class="list-group-item text-danger">{{$error}}</li>

                    @endforeach
                </ul>

                @endif


                <h2>Užsakymo forma</h2>

            <form action="/register" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Vardas</label>
                    <input type="text" class="form-control" id="name" placeholder="Įveskite vardą" name="name" value="{{old('name')}}">
                </div>
                <div class="form-group">
                    <label for="surname">Pavardė</label>
                    <input type="text" class="form-control" id="surname" placeholder="Įveskite pavardę" name="surname" value="{{old('surname')}}">
                </div>
                <div class="form-group">
                    <label for="adress">Adresas</label>
                    <input type="text" class="form-control" id="adress" placeholder="Įveskite jūsų adresą" name="adress" value="{{old('adress')}}">
                </div>
                <div class="form-group">
                    <label for="city">Miestas</label>
                    <input type="text" class="form-control" id="city" placeholder="Įveskite jūsų miestą" name="city" value="{{old('city')}}">
                </div>
                <div class="form-group">
                    <label for="email">Elektroninis paštas</label>
                    <input type="email" class="form-control" id="email" placeholder="Įveskite jūsų elektronį paštą" name="email" value="{{old('email')}}">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="type" name="type">
                    <label class="form-check-label" for="type">Remontas reikalingas skubiai</label>
                </div>

                <button type="submit" class="btn btn-default">Užsakymas.</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>
