<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create(Request $request){
          
        switch ($request->method) {
            case 'coingate':
                //code block
                break;
            case 'stripe':
                //code block;
            case 'fatoripay':
                //code block;
                break;
            default:
                return response()->json(['message' => 'Choose a valid payment method'], 400);
            }
    }
}
