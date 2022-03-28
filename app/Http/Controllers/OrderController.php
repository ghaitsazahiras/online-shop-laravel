<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show(){
        $data = DB::table('order')
            ->join('customer', 'order.cust_id', '=' , 'customer.cust_id')
            ->join('admin', 'order.adm_id', '=' , 'admin.adm_id')
            ->select('order.order_id', 'order.date', 'customer.name', 'admin.adm_name')
            ->get();
        return Response()->json($data);
    }

    public function detail($id){
        if(OrderModel::where('order_id', $id)->exists()){
            $data_order = DB::table('order')
            ->join('customer', 'order.cust_id', '=' , 'customer.cust_id')
            ->join('admin', 'order.adm_id', '=' , 'admin.adm_id')
            ->select('order.order_id', 'order.date', 'customer.name', 'admin.adm_name')
            ->where('order.order_id', '=', $id)
            ->get();
            return Response()->json($data_order);
        }else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    public function add(Request $request){
        $validator=Validator::make($request->all(),
        ['cust_id' => 'required',
        'adm_id' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $save = OrderModel::create([
            'cust_id' => $request->cust_id,
            'adm_id' => $request->adm_id, 
            'date' => date("Y-m-d")]);
            
        if($save){
            return Response()->json(['Successfully Add Data']);
        }else {
            return Response()->json(['Failed to Add Data']);
        } 
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['cust_id' => 'required',
        'adm_id' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $update = OrderModel::where('order_id', $id)->update([
            'cust_id' => $request->cust_id,
            'adm_id' => $request->adm_id, 
            'date' => date("Y-m-d")]);
            
            if($update) {
                return Response()->json(['Successfully Update Data']);
            }else{
                return Response()->json(['Failed to Update Data']);
            }
    }

    public function destroy($id){
        $delete = OrderModel::where('order_id', $id)->delete(); 
        if($delete) { 
            return Response()->json(['Successfully Delete Data']);
        }else { 
            return Response()->json(['Failed to Delete Data']); 
        }
    }
}
