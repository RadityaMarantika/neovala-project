<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware('permission:index permission', only: ['index']),
        ];
    }

  
    // This Method will return view of the permission page
    public function index(){
        $permission = Permission::orderBy('created_at','DESC')->paginate(10);
        return view('permission.list', [
            'permission' => $permission
        ]);
    }
    
    // This Method will return create of the permission page
    public function create(){
        return view('permission.create');
    }

    // This Method will return insert of the permission in Database
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [  
            'name' => 'required|unique:permissions|min:3',
        ]);  

        if ($validator->passes()) {  
            Permission::create(['name' => $request->name]);
            return redirect()->route('permission.index')->with('success', 'Permission created successfully');   
        } 
        else {
            return redirect()->route('permission.create')->withInput()->withErrors($validator);  
        }
    }  
    

    // This Method will return edit of the permission page
    public function edit($id){
        $permission = Permission::findOrFail($id);
        return view('permission.edit', [
            'permission' => $permission
        ]);
    }

     // This Method will return update of the permission data
     public function update($id, Request $request){

        $permission = Permission::findOrFail($id);

        $validator = Validator::make($request->all(), [  
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]);  

        if ($validator->passes()) {  
            $permission -> name = $request ->name;
            $permission -> save();
            return redirect()->route('permission.index')->with('success', 'Permission update successfully');   
        } 
        else {
            return redirect()->route('permission.edit', $id)->withInput()->withErrors($validator);  
        }
     }
     
    // This Method will return delete of the permission page
    public function delete(Request $request){
        $id = $request->id;
        $permission = Permission::find($id);

        if($permission == null){
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status'=>false
            ]);
        }

        $permission->delete();
        session()->flash('succsess', 'Delete Permission Success');
        return response()->json([
            'status'=>true
        ]);
    }
}
