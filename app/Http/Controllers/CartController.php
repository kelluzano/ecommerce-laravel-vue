<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Processing;
use App\Models\Product;
use Auth;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.checkout');
    }


    public function store(Request $request)
    {

        if(!$request->product_id){
            return [
                'message' => 'Cart items returned',
                'items' => Cart::where('user_id', auth()->user()->id)->sum('quantity')
            ];
        }

        $product = Product::where('id',$request->product_id)->first();

        $productFoundInCart = Cart::where('product_id', $request->product_id)->pluck('id');
        
        
        
        if($productFoundInCart->isEmpty()){

            $cart = Cart::create([
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->sale_price,
                'user_id' => auth()->user()->id

            ]);

        }else{
            $cart = Cart::where('product_id', $request->product_id)->increment('quantity');
        }

        $userItems = Cart::where('user_id', auth()->user()->id)->sum('quantity');

        if($cart){
            return [
                'message' => 'Cart Updated',
                'items' => $userItems
            ];
        }
    }

    public function getCartItemsForCheckout(){
        $cartItems = Cart::where('user_id', auth()->user()->id)->with('product')->get();

        $finalData = [];
        $amount = 0;
        if(isset($cartItems)):

            foreach($cartItems as $cartItem):

                if($cartItem->product){

                    foreach($cartItem->product as $cartProduct):
                        if($cartProduct->id == $cartItem->product_id):

                            $finalData[$cartItem->product_id]['id'] = $cartProduct->id;
                            $finalData[$cartItem->product_id]['name'] = $cartProduct->name;
                            $finalData[$cartItem->product_id]['sale_price'] = $cartItem->price;
                            $finalData[$cartItem->product_id]['quantity'] = $cartItem->quantity;
                            $finalData[$cartItem->product_id]['total'] = $cartItem->price * $cartItem->quantity;

                            $amount += $cartItem->price * $cartItem->quantity;

                            $finalData['totalAmount'] = $amount;
                        endif;
                        
                    endforeach;
                }
                
            endforeach;
            
        endif;

        return response()->json($finalData);
    }

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
                'client_id' => auth()->user()->id,
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

   public function updateProductQty(Request $request){

        $product = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->productId)->first();

        if($request->type == "increment"){
            $product->increment('quantity');
        }else{
            $product->decrement('quantity');
        }

        $data = [];
        $data['quantity'] = $product->quantity;
        $data['total'] = $product->quantity * $product->price;
        $data['totalItemCount'] = Cart::where('user_id', auth()->user()->id)->sum('quantity');
        return response()->json($data);
   }

   public function removeProduct(Request $request){

        $product = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->productId)->delete();
        $msg = "Product removed.";
        return ['message' => $msg,
            'totalItemCount' => Cart::where('user_id', auth()->user()->id)->sum('quantity')
        ];
   }
}
