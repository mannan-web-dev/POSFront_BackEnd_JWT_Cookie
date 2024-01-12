<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    function ProductPage(){
        return view('pages.dashboard.product-page');
    }

    public function CreateProduct(Request $request){
         $user_id = $request->header('id');
         //image create and upload 

         $img = $request->file('img');
         $t= time();
         $file_name= $img->getClientOriginalName();
         $img_name="{$user_id}-{$t}-{$file_name}";
         $img_url= "uploads/{$img_name}";

         $img->move(public_path("uploads"), $img_name);

   return Product::create([
            "user_id"=> $user_id,
            'category_id'=>$request->input('category_id'),
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('unit'),
            'img_url'=>$img_url,
         ]);

    }

    public function DeleteProduct(Request $request){
        $user_id = $request->header('id');
        $product_id = $request->input('product_id');
        $file_path = $request->input('file_path');
        File::delete($file_path);
        return Product::where('id',$product_id)->where('user_id',$user_id)->delete();
    }



    public function UpdateProduct(Request $request){
         $user_id=$request->header('id');
        $product_id=$request->input('id');

        if ($request->hasFile('img')) {

            // Upload New File
            $img=$request->file('img');
            $t=time();
            $file_name=$img->getClientOriginalName();
            $img_name="{$user_id}-{$t}-{$file_name}";
            $img_url="uploads/{$img_name}";
            $img->move(public_path('uploads'),$img_name);

            // Delete Old File
            $filePath=$request->input('file_path');
            File::delete($filePath);

            // Update Product

            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'img_url'=>$img_url,
                'category_id'=>$request->input('category_id')
            ]);

        }

        else {
            return Product::where('id',$product_id)->where('user_id',$user_id)->update([
                'name'=>$request->input('name'),
                'price'=>$request->input('price'),
                'unit'=>$request->input('unit'),
                'category_id'=>$request->input('category_id'),
            ]);
        }
    }
   

    public function ProductList(Request $request){
        $user_id = $request->header('id');
        return Product::where('user_id',$user_id)->get();

    }
    public function ProductByID(Request $request){
       $user_id = $request->header('id');
       $product_id = $request->input('id');
       return Product::where('id',$product_id)->where('user_id',$user_id)->first();
    }
}
