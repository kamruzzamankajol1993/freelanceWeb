<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkOutPage(){

        return view('front.checkout.checkout');
    }
}
