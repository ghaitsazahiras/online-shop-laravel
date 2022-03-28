<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function show(){
        return ProductModel::all();
    }

    public function detail($id){
        if(ProductModel::where('product_id', $id)->exists()){
            $data = DB::table('product')
            ->where('product.product_id', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    public function add(Request $request){
        $validator=Validator::make($request->all(),
        ['product_name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'photo' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $save = ProductModel::create([
            'product_name' => $request->product_name,
            'description' => $request->description, 
            'price' => $request->price,
            'photo' => $request->photo]);
            
        if($save){
            return Response()->json(['Successfully Add Data']);
        }else {
            return Response()->json(['Failed to Add Data']);
        }
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['product_name' => 'required',
        'description' => 'required',
        'price' => 'required',
        'photo' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $update = ProductModel::where('product_id', $id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description, 
            'price' => $request->price,
            'photo' => $request->photo]);
            
            if($update) {
                return Response()->json(['Successfully Update Data']);
            }else{
                return Response()->json(['Failed to Update Data']);
            }
    }

    public function destroy($id){
        $delete = ProductModel::where('product_id', $id)->delete(); 
        if($delete) { 
            return Response()->json(['Successfully Delete Data']);
        }else { 
            return Response()->json(['Failed to Delete Data']); 
        }
    }
}
