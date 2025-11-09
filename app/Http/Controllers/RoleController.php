<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware('permission:index role', only: ['index']),
        ];
    }

  
    // This Method will return view of the role page
    public function index(){
        $role = Role::orderBy('created_at','DESC')->paginate(10);
        return view('role.list', [
            'role' => $role
        ]);
    }
    
    // This Method will return create of the role page
    public function create(){

        $permission = Permission::orderBy('name','ASC')->get();

        return view ('role.create', [
            'permission' => $permission
        ]);
    }

    // This Method will return insert of the permission in Database
    public function store(Request $request){
        $validator = Validator::make($request->all(), [  
            'name' => 'required|unique:roles',
        ]);  

        if ($validator->passes()) {  
            
           $role = Role::create(['name' => $request->name]);

            if(!empty($request->permission)){
                foreach ($request->permission as $name){
                    $role->givePermissionTo($name);

                }
            }

            return redirect()->route('role.index')->with('success', 'Role created successfully');   
        } 
        else {
            return redirect()->route('role.create')->withInput()->withErrors($validator);  
        }
    }  
    

    // This Method will return edit of the permission page
    public function edit($id){
        $role = Role::findOrFail($id);
        $hasPermission = $role->permissions->pluck('name');
        $permission = Permission::orderBy('name','ASC')->get();

        return view('role.edit', [
            'permission' => $permission,
            'hasPermission' => $hasPermission,
            'role' => $role,
        ]);
    }

     // This Method will return update of the permission data
     public function update($id, Request $request){
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [  
            'name' => 'required|unique:roles,name,'.$id.',id'
        ]);  

        if ($validator->passes()) {  
            
           //$role = Role::create(['name' => $request->name]);
           $role->name = $request->name;
           $role->save();

            if(!empty($request->permission)){
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            return redirect()->route('role.index')->with('success', 'Role Update successfully');   
        } 
        else {
            return redirect()->route('role.edit', $id)->withInput()->withErrors($validator);  
        }
     }
     
    // This Method will return delete of the permission page
    public function delete(Request $request){
        $id = $request->id;
        $role = Role::find($id);

        if($role == null){
            session()->flash('error', 'Role not found');
            return response()->json([
                'status'=>false
            ]);
        }

        $role->delete();
        session()->flash('succsess', 'Delete Role Success');
        return response()->json([
            'status'=>true
        ]);
    }
}

