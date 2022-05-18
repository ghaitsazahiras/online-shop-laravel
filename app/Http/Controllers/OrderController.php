<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\DetailOrderModel;
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

    public function store(Request $request)
    {
        $data=array(
            'date'=>date('Y-m-d'),
            'subtotal'=>0
        );
        $proses=OrderModel::create($data);

        if($proses){
            $order_id=$proses->order_id;
            $subtotal=0;
            foreach ($request->get('datapost') as $gdata){
                $insert_detail=DetailOrderModel::create([
                    'order_id'=>$order_id,
                    'product_id'=>$gdata['product_id'],
                    'qty'=>$gdata['quantity'],
                    // 'subtotal'=>$subtotal
                ]);
                $subtotal+=$gdata['price']*$gdata['quantity'];
            }
            $updatetransaksi=OrderModel::where('order_id', $order_id)->update([
                'subtotal'=>$subtotal
            ]);
            if($proses) {
                    return Response()->json([
                        'status'=>1,
                        'message'=>'Successfully Add Transaction'
                    ]);
                }
                else {
                    return Response()->json([
                        'status'=>0,
                        'message'=>'Failed Add Transaction'
                    ]);
                }
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
