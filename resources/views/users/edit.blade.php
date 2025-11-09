@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-base text-gray-800 leading-tight">
                Users Edit Role
            </h2>
            <a href="{{ route('users.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-2 rounded shadow">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">  
                        @csrf  
                        <div>  
                            <label for="" class="text-sm font-medium">Name</label>
                            <div class="my-1">  
                                <input value="{{ old('name', $user->name) }}" name="name" placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">  
                                @error('name')  
                                    <p class="text-red-400 font-medium">{{ $message }}</p>  
                                @enderror  
                            </div>

                            <label for="" class="text-sm font-medium">Email</label>
                            <div class="my-2">  
                                <input value="{{ old('email', $user->email) }}" name="email" placeholder="Enter email" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">  
                                @error('email')  
                                    <p class="text-red-400 font-medium">{{ $message }}</p>  
                                @enderror  
                            </div>
<hr>
                            <div class="grid grid-cols-1 mb-3">
                                @if($roles->isNotEmpty())
                                    @foreach ( $roles as $role )
                                        <div class="mt-3">
                                            <input {{ ($hasRoles->contains($role->id)) ? 'checked' : '' }} 
                                            type="checkbox" id="role-{{$role->id}}" class="rounded" name="role[]" value="{{ $role->name }}">
                                            <label for="role-{{$role->id}}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <br>  
                            <button class="bg-black text-sm rounded-md text-white px-3 py-2">Update</button>  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection

