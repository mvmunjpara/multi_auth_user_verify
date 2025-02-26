<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index(){
        return view('category.list');
    }
    public function fetchcategory(){
         $fetchcategory = Category::all();
        return response()->json([
            'fetchcategory'=>$fetchcategory,
        ]);
    }
    public function create(){
        return view('category.create');
    }
    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),['name'=>'required']);

        if($validator->fails()){
            return response()->json(['status'=>400,'errors'=>$validator->errors()]);
        }else{
            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
            session()->flash('success','Category create successfully !');
            return response()->json(['status'=>true,'code'=>200,'message'=>'Category create successfully!']);
        }
    }
    public function edit($id)
    {
        $category = Category::find($id);
        $data['category'] = $category;
        if($category)
        {
            return view('category.edit',$data);
        }
        else
        {
            return response()->json(['status'=>404,'message'=>'Categoory Not Found']);
           
        }
    }
    public function update(Request $request,$id){
        // dd($request->all());
        $validator = Validator::make($request->all(),['name'=>'required']);

        if($validator->fails()){
            return response()->json(['status'=>400,'errors'=>$validator->errors()]);
        }else{
            $category =  Category::find($id);
            if($category){

            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
            session()->flash('success','Category update successfully !');
            return response()->json(['status'=>true,'code'=>200,'message'=>'Category update successfully!']);
            }else{
                return response()->json(['status'=>404,'message'=>'Categoory not found']);
            }
        }
    }
    public function destroy($id){
        $category = Category::find($id);
        if($category){
            $category->delete();
            session()->flash('success','Category delete successfully !');
            return response()->json(['status'=>200,'message'=>'Category delete successfully !']);
        }else{
            return response()->json(['status'=>404,'message'=>'Not Found']);
        }
    }
}
