<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DetailOrderModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailOrderController extends Controller
{
    public function show(){
        $data = DB::table('detail_order')
            ->join('order', 'detail_order.order_id', '=' , 'order.order_id')
            ->join('product', 'detail_order.product_id', '=' , 'product.product_id')
            ->select('order.order_id', 'order.date', 'order.cust_id', 'product.product_id', 'product.product_name', 'detail_order.qty')
            ->get();
        return Response()->json($data);
    }

    public function detail($id){
        if(DetailOrderModel::where('detail_id', $id)->exists()){
            $data_detail = DB::table('detail_order')
            ->join('order', 'detail_order.order_id', '=' , 'order.order_id')
            ->join('product', 'detail_order.product_id', '=' , 'product.product_id')
            ->select('order.order_id', 'order.date', 'order.cust_id', 'product.product_id', 'product.product_name', 'detail_order.qty')
            ->where('detail_order.detail_id', '=', $id)
            ->get();
            return Response()->json($data_detail);
        }else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    public function add(Request $request){
        $validator=Validator::make($request->all(),
        ['order_id' => 'required',
        'product_id' => 'required',
        'qty' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $product_id = $request->product_id;
        $qty = $request->qty;
        $price = DB::table('product')->where('product_id', $product_id)->value('price');
        // $subtotal = $price * $qty;

        $save = DetailOrderModel::create([
            'order_id' => $request->order_id,
            'product_id' => $product_id, 
            'qty' => $qty,
            // 'subtotal' => $subtotal
        ]);
            
        if($save){
            return Response()->json(['Successfully Add Data']);
        }else {
            return Response()->json(['Failed to Add Data']);
        } 
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['order_id' => 'required',
        'product_id' => 'required',
        'qty' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $product_id = $request->product_id;
        $qty = $request->qty;
        $price = DB::table('product')->where('product_id', $product_id)->value('price');
        // $subtotal = $price * $qty;

        $update = DetailOrderModel::where('detail_id', $id)->update([
            'order_id' => $request->order_id,
            'product_id' => $product_id, 
            'qty' => $qty,
            // 'subtotal' => $subtotal
        ]);
            
            if($update) {
                return Response()->json(['Successfully Update Data']);
            }else{
                return Response()->json(['Failed to Update Data']);
            }
    }

    public function destroy($id){
        $delete = DetailOrderModel::where('detail_id', $id)->delete(); 
        if($delete) { 
            return Response()->json(['Successfully Delete Data']);
        }else { 
            return Response()->json(['Failed to Delete Data']); 
        }
    }
}
