<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function show(){
        return CustomerModel::all();
    }

    public function detail($id){
        if(CustomerModel::where('cust_id', $id)->exists()){
            $data = DB::table('customer')
            ->where('customer.cust_id', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    public function add(Request $request){
        $validator=Validator::make($request->all(),
        ['name' => 'required',
        'address' => 'required',
        'telp' => 'required',
        'username' => 'required',
        'password' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $save = CustomerModel::create([
            'name' => $request->name,
            'address' => $request->address, 
            'telp' => $request->telp,
            'username' => $request->username, 
            'password' => Hash::make($request->password)]);

        $data = CustomerModel::where('name', '=', $request->name)-> get();
            
        if($save){
            return Response() -> json([
                'status' => 1,
                'message' => 'Succes create new data!',
                'data' => $data
            ]);
        }else {
            return Response() -> json([
                'status' => 0,
                'message' => 'Failed create data!'
            ]);
        } 
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['name' => 'required',
        'address' => 'required',
        'telp' => 'required',
        'username' => 'required',
        'password' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $update = CustomerModel::where('cust_id', $id)->update([
            'name' => $request->name,
            'address' => $request->address, 
            'telp' => $request->telp,
            'username' => $request->username, 
            'password' => Hash::make($request->password)]);
            
            if($update) {
                return Response()->json(['Successfully Update Data']);
            }else{
                return Response()->json(['Failed to Update Data']);
            }
    }

    public function destroy($id){
        $delete = CustomerModel::where('cust_id', $id)->delete(); 
        if($delete) { 
            return Response()->json(['Successfully Delete Data']);
        }else { 
            return Response()->json(['Failed to Delete Data']); 
        }
    }
}
