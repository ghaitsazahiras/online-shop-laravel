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
        'price' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $save = ProductModel::create([
            'product_name' => $request->product_name,
            'description' => $request->description, 
            'price' => $request->price]);
            
        $data = ProductModel::where('product_name', '=', $request->product_name)-> get();

        if($save){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes create new data!',
                'data' => $data
            ]);
        } else 
        {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed create data!'
            ]);
        }
    }

    public function upload_photo(Request $req, $id)
    {
        $validator = Validator::make($req->all(),[
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        //define nama file yang akan di upload
        $imageName = time () .'.'. $req->photo->extension();

        //proses upload
        $req->photo->move(public_path('images'), $imageName);

        $update=ProductModel::where('product_id',$id)->update([
            'photo' => $imageName
        ]);

        $data = ProductModel::where('product_id', '=', $id)-> get();

        if($update){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes upload photo product!',
                'data' => $data
            ]);
        } else 
        {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed upload photo product!'
            ]);
        }
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['product_name' => 'required',
        'description' => 'required',
        'price' => 'required',
        // 'photo' => 'required'
        ]);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $update = ProductModel::where('product_id', $id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description, 
            'price' => $request->price,
            // 'photo' => $request->photo
        ]);
            
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
