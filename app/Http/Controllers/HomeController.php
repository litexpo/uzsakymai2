<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function index()
    {

        // Gražinamss reikiamas view
        return view('home');
    }


    public function store(Request $request)
    {
        /* Tikrinama ar tinkamai užpildyti registracijos
           laukai */
        $validatedData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'adress' => 'required',
            'city' => 'required',
            'email' => 'required|unique:orders'
        ]);

        // Saugomi duomenys duomenų bazėje
        $order = new App\Order();
        $order->name = $request->name;
        $order->surname = $request->surname;
        $order->adress = $request->adress;
        $order->city = $request->city;
        $order->email = $request->email;

        if(isset($request->type))
        $order->is_fast = $request->type;
        else
            $order->is_fast = 'off';

        $order->save();

        /* Į sesiją įrašomas kintamasis,
           jog reikia parodyti pavykusios registracijos
           pranešimą */
        Session::flash('success');

        // Nukreipiama į užsakymų puslapį
        return redirect(route('uzsakymai.index'));
    }





}
