<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Input;


class OrderController extends Controller
{
    public function index()
    {
        /* Jeigu vartotojas yra kaiką įvedęs paieškos laukelyje
           tuomet iškviečiamas search action'as, kuris apdoros paiešką*/
        if(request()->has('q')){
            return redirect()->action(
                'OrderController@search', [
                    'q' => request()->get('q'),
                    'sort-name'  => request()->get('sort-name'),
                    'fast' => request()->get('fast'),
                    'sort-surname' => request()->get('sort-surname'),
                    'sort-date' => request()->get('sort-date'),
                    'sort-city' => request()->get('sort-city')
                ]
            );
        }

        /* Tikrinama ar yra duomenų filtras, jei taip
           atrenkami tik tie duomenys, kurių reikia, jei ne
           paimami visi duomenys */
        $orders = new App\Order;
        if(request()->has('fast')){
            $orders = $orders::where('is_fast', request('fast'));
        }else{
            $orders = $orders::where('id', '>', 0);
        }

        /* Funkcija išrikiuoja duomenis, jei varotojas
           to norėjo */
        $this->Quering($orders);


        /* Duomenys suskirstomi į puslapius */
        $orders = $orders->paginate(5)->appends([
            'fast' => request('fast'),
            'sort-name' => request('sort-name'),
            'sort-surname' => request('sort-surname'),
            'sort-date' => request('sort-date'),
            'sort-city' => request('sort-city'),
            'q' => request()->get('q'),
        ]);

        /* Grąžinamas reikiamas view su atrinktais duomenimis */
        return view('orders')->with(['orders' => $orders,
                                            'q' => request('q')]);
    }

    public function search(Request $request){



        /* Jeigu yra panaudota paieška, ir buvo norima pasiekti kitą puslapį,
           į requestą reikia įrašyti paieškos reikšmę(q), kad atidarytas puslapis
           toliau vaizduotų paieškos duomenis. Tai įvygdoma per naujo įkraunant puslapį,
           pridedant duomenis iš sesijos */
        if(request()->has('page') && !request()->has('q')){
            return redirect()->action('OrderController@search',
                ['q' => session('q'),
                'page' => request('page'),
                'sort-name' => session('sort-name'),
                'sort-surname' => session('sort-surname'),
                 'sort-date' => session('sort-date'),
                 'sort-city' => session('sort-city'),
                 'fast' => session('fast')
                ]
            );
        }


        /* Tikrinama ar paieškos langelis nebuvo tuščias
           , jei taip nukreipiama atgal į pagrindinį užsakymų
            puslapį */
        if(Input::has('q')) {
            if(!Input::get('q')){
                return redirect()->action('OrderController@index');
            }
        }


        /* Randame duomenis pagal filtrą jeigu vartotojas to prašė. Jei ne,
           tiesiog randami ieškoti duomenys. */
           $orders = $this->searchQuery();


        // Surikiuojami duomenys jei reikia
            $this->Quering($orders);
        // Duomenys išskirstomi į puslapius
            $orders = $orders->paginate(5);
        /* Sesijoje išsugoma paieška, kad galėtumėme naviguoti per puslpius,
           neprarandant paieškos. Taip pat ir parametrai, pagal kuriuos rodyti rezultatus */
            session(['q' => request('q')]);

        // Sutvarkomi sesijos duomenys, jog būtų teisingai rodomi rezultatai
             $this->handleSession();

        // Grąžinamas reikiamas view su atrinktais ir sutvarkytais duomenimis.
            return view('orders')->with(['orders' => $orders,
                                                'q' => request('q')]);


    }

    private function handleSession(){

        /* Pagal tai kokie rikiavimo ir filtravimo parametrai parinkti
           reikia sutvarkyti sesiją, jog ji teisingai rodytų duomemis */

        if(request()->has('sort-name')){
            session(['sort-surname' => null]);
            session(['sort-date' => null]);
            session(['sort-city' => null]);
            session(['sort-name' => request('sort-name')]);
        }else if(request()->has('sort-surname')){
            session(['sort-name' => null]);
            session(['sort-date' => null]);
            session(['sort-city' => null]);
            session(['sort-surname' => request('sort-surname')]);
        }else if(request()->has('sort-city')){
            session(['sort-surname' => null]);
            session(['sort-date' => null]);
            session(['sort-name' => null]);
            session(['sort-city' => request('sort-city')]);
        }else if(request()->has('sort-date')){
            session(['sort-surname' => null]);
            session(['sort-city' => null]);
            session(['sort-name' => null]);
            session(['sort-date' => request('sort-date')]);
        }


        if(request()->has('fast')){
            session(['fast' => request('fast')]);
        }else{
            session(['fast' => null]);
        }
    }

    private function Quering($orders)
    {
        /* Funkcija surikiuoja $orders kintamojo duomenis
           pagal tai, ko prašė vartotojas */

        if(request()->has('sort-name')){

            $orders = $orders->OrderBy('name', request('sort-name'));
        }

        if(request()->has('sort-surname')){
            $orders = $orders->OrderBy('surname', request('sort-surname'));
        }

        if(request()->has('sort-date')){
            $orders = $orders->OrderBy('created_at', request('sort-date'));
        }

        if(request()->has('sort-city')){
            $orders = $orders->OrderBy('city', request('sort-city'));
        }

        return $orders;
    }

    private function searchQuery(){

        /* Jeigu pasirinktas filtras funkcija atrenka tik reikiamus duomenis
           , jei ne, tuomet visus tuos, kurie atitinka paiešką. */

        if(request()->has('fast')){

            $orders = App\Order::Where(function($query)
            {
                $query->where('name', 'like', '%'.request('q').'%')
                    ->where('is_fast', '=', request('fast'));
            })->OrWhere(function ($query)
            {
                $query->where('surname', 'like', '%'.request('q').'%')
                    ->where('is_fast', '=', request('fast'));
            })->OrWhere(function ($query)
            {
                $query->where('adress', 'like', '%'.request('q').'%')
                    ->where('is_fast', '=', request('fast'));
            })->OrWhere(function ($query)
            {
                $query->where('city', 'like', '%'.request('q').'%')
                    ->where('is_fast', '=', request('fast'));
            })->OrWhere(function ($query)
            {
                $query->where('email', 'like', '%'.request('q').'%')
                    ->where('is_fast', '=', request('fast'));
            });
        }else{
            $orders = App\Order::where('name', 'Like', '%'.request('q').'%')
                ->OrWhere('surname', 'Like', '%'.request('q').'%')
                ->OrWhere('adress', 'Like', '%'.request('q').'%')
                ->OrWhere('city', 'Like', '%'.request('q').'%')
                ->OrWhere('email', 'Like', '%'.request('q').'%')
            ;

        }

        return $orders;
    }
}
