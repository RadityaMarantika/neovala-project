<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware('permission:index user', only: ['index']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = User::latest()->paginate(10);
        return view ('users.list',[
            'user' => $user

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRoles = $user->roles->pluck('id');
        
        return view ('users.edit',[
            'user' => $user,
            'roles' => $roles,
            'hasRoles' => $hasRoles

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [  
            'name' => 'required|min:3',
            'email' => 'required|unique:users,email,'.$id.',id'
        ]);  

        if ($validator->fails()) {
            return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
        }  
            
           //$role = Role::create(['name' => $request->name]);
           $user->name = $request->name;
           $user->email = $request->email;
           $user->save();

           $user->syncRoles($request->role);

           return redirect()->route('users.index')->with('success', 'User Update successfully');     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
