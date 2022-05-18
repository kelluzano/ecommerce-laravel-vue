<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Processing;
use App\Models\Product;
use Auth;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class ProcessingController extends Controller
{
    public function processPayment(Request $request){

        $firstName = $request->firstName;
        $lastName = $request->lastName;
        $email = $request->email;
        $phone_number = $request->phone_number;
        $address = $request->address;
        $city = $request->city;
        $zipCode = $request->zipCode;
        $country = $request->country;
        $cardType = $request->cardType;
        $cardNumber = $request->cardNumber;
        $expMonth = $request->expMonth;
        $expYear = $request->expYear;
        $cvv = $request->cvv;
        $amount = $request->amount;
        $state = $request->state;

        $orders = $request->order;
        $orderArray = [];
        foreach($orders as $order):
            if(isset($order['id'])){

                $orderArray[$order['id']] = [
                    'order_id' => $order['id'],
                    'quantity' => $order['quantity']
                ];
            }
            
        endforeach;

        $stripe = Stripe::make(env('STRIPE_API_KEY'));
        $token = $stripe->tokens()->create([
            'card' => [
                'number'    => $cardNumber,
                'exp_month' => $expMonth,
                'exp_year'  => $expYear,
                'cvc'       => $cvv,
            ],

        ]);

        if(!$token['id']){
            session()->flush('error', 'Stripe Token generation failed');
            return;
        }

        $customer = $stripe->customers()->create([
            'name' => $firstName.' '.$lastName,
            'email' => $email,
            'phone' => $phone_number,
            'address' => [
                'line1' => $address,
                'postal_code' => $zipCode,
                'city' => $city,
                'state' => $state,
                'country' => $country,
            ],
            'shipping' => [
                'name' => $firstName.' '.$lastName,
                'address' => [
                    'line1' => $address,
                    'postal_code' => $zipCode,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                ],
            ],
            'source' => $token['id'],
        ]);

        $charge = $stripe->charges()->create([
            'customer' => $customer['id'],
            'currency' => 'USD',
            'amount'   => $amount,
            'description' => 'Payment for order',
        ]);

        if($charge['status'] == "succeeded"){

            $customerId = $charge['id'];
            $amountReceived = $charge['amount'];

            $addressDetail = [
                'address' => [
                    'line1' => $address,
                    'postal_code' => $zipCode,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                ]
            ];
            
            $processingDetails = Processing::create([
                'user_id' => auth()->user()->id,
                'client_name' => $firstName.' '.$lastName,
                'client_address' => json_encode($addressDetail),
                'order_details' => json_encode($orderArray),
                'amount' => $amount
            ]);

            if($processingDetails){
                Cart::where('user_id', auth()->user()->id)->delete();
                return ['success' => 'Order completed successfully'];
            }

        }else{
           return ['error' => 'Order failed'];
       }

   }
}
