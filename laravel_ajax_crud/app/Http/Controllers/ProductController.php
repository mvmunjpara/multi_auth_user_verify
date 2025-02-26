<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function products(){
        $products = Product::latest()->paginate(5);
        return view('products',compact('products'));
    }
    //add product
    public function addProduct(Request $request){
        $request->validate(
            [
                'name'=>'required|unique:products',
                'price'=>'required'
            ],
            [
                'name.required'=>'Name is required',
                'name.unique'=>'Porduct Name is already exists',
                'price.required'=>'Price is required'
            ]);
        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();
        return response()->json(['status'=>'success']);

    }
    //update product
    public function updateProduct(Request $request){
        $request->validate(
            [
                'up_name'=>'required',
                'up_price'=>'required'
            ],
            [
                'up_name.required'=>'Name is required',
                'up_name.unique'=>'Name is already exists',
                'up_price.required'=>'Price is required'
            ]);
        $product = Product::where('id',$request->up_id)->update(
            [
                'name'=>$request->up_name,
                'price'=>$request->up_price
            ]
        );
        return response()->json(['status'=>'success']);
    }
    //delete product
    public function deleteProduct(Request $request){
        $product = Product::find($request->product_id)->delete();
        return response()->json(['status'=>'success']);
    }
    //pagination
    public function pagination(Request $request){
        $products = Product::latest()->paginate(5);
        return view('pagination_products',compact('products'));
    }
    //search product
    public function searchProduct(Request $request){
        $products = Product::where('name','like','%'.$request->search_string.'%')->orWhere('price','like','%'.$request->search_string.'%')->orderBy('id','desc')->paginate(5);
        if($products->count() >=1){
            return view('pagination_products',compact('products'))->render();
        }else{
            return response()->json(['status'=>'nothing_found']);
        }
    }
}
