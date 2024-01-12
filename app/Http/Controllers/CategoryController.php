<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    function CategoryPage(){
        return view('pages.dashboard.category-page');
    }


    public function CategoryList(Request $request){
      $user_id=$request->header('id');
      return Category::where('user_id',$user_id)->get();
    }
    public function CategoryCreate(Request $request){
           
        try {
            $user_id=$request->header('id');
            Category::create([
                'name'=>$request->name,
                'user_id'=>$user_id,
            ]);
            return response()->json(["satus"=>"success", "message"=> "category Created successfuly"]);
        } catch (Exception $e) {
            return response()->json(["status"=> "error", "message"=> "user create has been fail"]);
        }



    }
    public function CategoryDelete(Request $request){
        try {
            $user_id=$request->header("id");
            $Category_id= $request->input("id");
            Category::where("id", $Category_id)->where("user_id",$user_id)->delete();
            return response()->json(["status"=> "success", "message"=> "Category has been deleted"]);
        } catch (Exception $e) {
            return response()->json(["status"=> "error", "message"=> "Somethingis went"]);
        }
    }
    public function CategoryUpdate(Request $request){
      try {
          $user_id=$request->header("id");
          $category_id= $request->input("id");
          Category::where("id", $category_id)->where("user_id", $user_id)->update([
            "name"=>$request->name,
          ]);
          return response()->json(["status"=> "success", "message"=> "Category Updated"]);
      } catch (Exception $e) {
        return response()->json(["status"=> "error", "message"=> "something are went"]);
      }
    }

    public function CategoryByID(Request $request){

        $user_id=$request->header("id");
        $category_id= $request->input("id");
        return Category::where("id", $category_id)->where("user_id", $user_id)->first();
    }
}
