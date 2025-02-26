<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;
class ProductController extends Controller
{
    public function index(){
        $categories = Category::all();
        // $products = Product::with('cats')->get();
         $products = Product::select([
            'id',
            'cat_id',
            'name',
            'description',
            'image',
            'price',
            'quantity',
            'manufatured_date',
            'expiry_date',
        ])->with('category')
        ->orderBy('id', 'asc')
        ->get();

        $data['categories']=$categories;
        $data['products']=$products;
        // foreach($products as $product)
        // {
        //    echo  $product->category->name;
        // }
        return view('product.list',$data);
    }
    public function fetchproduct(){
        $fetchproduct = Product::with('category')->get();
        return response()->json([
            'fetchproduct'=>$fetchproduct,
        ]);
    }
    public function create(){
        $categories = Category::all();
        $data['categories']=$categories;
        return view('product.create',$data);
    }
    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'image'=>'required',
            'price'=>'required',
            'quantity'=>'required',
            'manufatured_date'=>'required',
            'expiry_date'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>400,'errors'=>$validator->errors()]);
        }else{
            $product = new Product;
            $product->cat_id = $request->cat_id;
            $product->name = $request->name;
            $product->description = $request->description;
            // $product->image = $request->image;
            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->move('uploads/product/', $filename);
                $product->image = $filename;
            }
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->manufatured_date = $request->manufatured_date;
            $product->expiry_date = $request->expiry_date;
            $product->save();
            session()->flash('success','Product create successfully !');
            return response()->json(['status'=>200,'success'=>'Product create successfully !']);
        }
    }
    public function edit($id){
        $product = Product::find($id);
        $categories = Category::all();
        $data['categories'] = $categories;
        $data['product'] = $product;
        // dd($data);
        return view('product.edit',$data);
    
    }
    public function update(Request $request,$id){
        
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            // 'description'=>'required',
            // 'image'=>'required',
            // 'price'=>'required',
            // 'quantity'=>'required',
            // 'manufatured_date'=>'required',
            // 'expiry_date'=>'required'
        ]);
        if($validator->fails()){
            return response()->json(['status'=>400,'errors'=>$validator->errors()]);
        }else{
            $product = Product::find($id);
            $product->cat_id = $request->cat_id;
            $product->name = $request->name;
            $product->description = $request->description;
            // $product->image = $request->image;
            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->move('uploads/product/', $filename);
                $product->image = $filename;
            }
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->manufatured_date = $request->manufatured_date;
            $product->expiry_date = $request->expiry_date;
            $product->save();
            session()->flash('success','Product update successfully !');
            return response()->json(['status'=>200,'success'=>'Product update successfully !']);
        }   
    }
}
