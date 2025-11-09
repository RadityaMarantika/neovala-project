@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-base text-gray-800 leading-tight">
                Users List
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 overflow-auto"> 
                <div class="min-w-[800px]">
                    <table class="w-full text-xs table-auto border-collapse">
                        <thead class="bg-gray-50">
                            <tr class="border-b text-gray-700">
                                <th class="px-2 py-2 text-left w-16">#</th>
                                <th class="px-2 py-2 text-left">Name</th>
                                <th class="px-2 py-2 text-left">Role</th>
                                <th class="px-2 py-2 text-center w-28">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs bg-white text-sm">
                            @if($user->isNotEmpty())
                                @foreach ($user as $key => $user)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-2 py-2 text-left">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-2 py-2 text-left whitespace-nowrap">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-2 py-2 text-left whitespace-nowrap">
                                        {{ $user->roles->pluck('name')->implode(', ') }}
                                    </td>{{--
                                    <td class="px-2 py-2 text-right whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}
                                    </td>--}}
                                    <td class="px-2 py-2 text-center">
                                        <a href="{{ route("users.edit", $user->id) }}" class="text-yellow-500 hover:text-yellow-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-400">No data found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
