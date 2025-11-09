@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-base text-gray-800 leading-tight">
                Permissions List
            </h2>
            <a href="{{ route('permission.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded shadow">
                +New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 overflow-auto"> 
                <div class="min-w-[800px]">
                    <table class="w-full text-xs">
                        <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" width="60">No</th>
                                <th class="px-6 py-3 text-center">Name</th>
                                <th class="px-6 py-3 text-left" width="100">Created</th>
                                <th class="px-6 py-3 text-center" width="100">Action</th>
                            </tr>
                            <tr class="border-b">
                                <th class="px-6 py-2 text-left">
                                    <input type="text" class="border w-full px-3 py-2 rounded text-sm" placeholder="Search No">
                                </th>
                                <th class="px-6 py-2 text-center">
                                    <input type="text" class="border w-full px-3 py-2 rounded text-sm" placeholder="Search Name">
                                </th>
                                <th class="px-6 py-2 text-left">
                                    <input type="text" class="border w-full px-3 py-2 rounded text-sm" placeholder="Search Date">
                                </th>
                                <th class="px-6 py-2 text-center">
                                    <input type="text" class="border w-full px-3 py-2 rounded text-sm" placeholder="Search Action">
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @if($permission->isNotEmpty())
                                @foreach ($permission as $key => $permission)
                                <tr class="border-b">
                                    <td class="px-6 py-3 text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-3 text-left">
                                        {{ $permission->name }}
                                    </td>
                                    <td class="px-6 py-3 text-left">
                                        {{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <a href="{{ route("permission.edit", $permission->id) }}" class="text-yellow-500">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="deletePermission({{ $permission->id }})" class="text-red-500">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id){
                if (confirm("Are you sure want to delete ?")){
                    $.ajax({
                        url     :'{{ route ("permission.delete") }}',
                        type    :'delete',
                        data    :{id:id},
                        dataType:'json',
                        headers :{ 'x-csrf-token' :'{{ csrf_token() }}'
                        },
                        success:function(response){
                            window.location.href = '{{ route("permission.index") }}';
                        }
                    });
                }
            }
        </script>
    </x-slot>

</x-app-layout>

@endsection()
