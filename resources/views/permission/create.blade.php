@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-base text-gray-800 leading-tight">
                Permissions Create
            </h2>
            <a href="{{ route('permission.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded shadow">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permission.store') }}" method="POST">  
                        @csrf  
                        <div>  
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">  
                                <input value="{{ old('name') }}" name="name" placeholder="Enter Name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">  
                                @error('name')  
                                    <p class="text-red-400 font-medium">{{ $message }}</p>  
                                @enderror  
                            </div>
                            <br>  
                            <button class="bg-black text-sm rounded-md text-white px-3 py-2">Submit</button>  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection

