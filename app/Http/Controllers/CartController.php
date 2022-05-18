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
