<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductsController extends Controller
{
    public function index(){

        $auth_user_id = auth()->user()->id ?? 0;
        return view('content.products', ['auth_user_id' => $auth_user_id]);
        
    }

    public function getProducts(){
        $products = Product::select('id','name','slug','image_name','price','sale_price')->get()->toArray();

        return response()->json($products);
    }
}
