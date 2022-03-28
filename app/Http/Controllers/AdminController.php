<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function show(){
        return AdminModel::all();
    }

    public function detail($id){
        if(AdminModel::where('adm_id', $id)->exists()){
            $data = DB::table('admin')
            ->where('admin.adm_id', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Data Not Found']);
        }
    }

    public function add(Request $request){
        $validator=Validator::make($request->all(),
        ['adm_name' => 'required',
        'username' => 'required',
        'password' => 'required',
        'level' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $save = AdminModel::create([
            'adm_name' => $request->adm_name,
            'username' => $request->username, 
            'password' => Hash::make($request->password),
            'level' => $request->level]);
            
        if($save){
            return Response()->json(['Successfully Add Data']);
        }else {
            return Response()->json(['Failed to Add Data']);
        } 
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['adm_name' => 'required',
        'username' => 'required',
        'password' => 'required',
        'level' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $update = AdminModel::where('adm_id', $id)->update([
            'adm_name' => $request->adm_name,
            'username' => $request->username, 
            'password' => Hash::make($request->password),
            'level' => $request->level]);
            
            if($update) {
                return Response()->json(['Successfully Update Data']);
            }else{
                return Response()->json(['Failed to Update Data']);
            }
    }

    public function destroy($id){
        $delete = AdminModel::where('adm_id', $id)->delete(); 
        if($delete) { 
            return Response()->json(['Successfully Delete Data']);
        }else { 
            return Response()->json(['Failed to Delete Data']); 
        }
    }
}
