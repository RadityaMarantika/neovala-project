@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-base text-gray-800 leading-tight">Roles List</h2>
            <a href="{{ route('role.create') }}"
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
                    <table class="min-w-[1200px] text-sm border text-xs" id="main-table">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="px-6 py-3 text-left w-[100px]">#</th>
                                <th class="px-6 py-3 text-center">Name</th>
                                <th class="px-6 py-3 text-center">Permission</th>
                                <th class="px-6 py-3 text-center">Created</th>
                                <th class="px-6 py-3 text-right w-[120px]">Action</th>
                            </tr>
                            <tr class="bg-gray-100 border-b">
                                <td></td>
                                <td class="px-6 py-2 text-center">
                                    <input type="text" id="filter-name" placeholder="Search name"
                                        class="w-full px-3 py-2 border rounded-md text-sm" oninput="filterTable()">
                                </td>
                                <td class="px-6 py-2 text-center">
                                    <input type="text" id="filter-permission" placeholder="Search permission"
                                        class="w-full px-3 py-2 border rounded-md text-sm" oninput="filterTable()">
                                </td>
                                <td class="px-6 py-2 text-center">
                                    <input type="text" id="filter-created" placeholder="Search date"
                                        class="w-full px-3 py-2 border rounded-md text-sm" oninput="filterTable()">
                                </td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody id="role-table">
                            @foreach ($role as $key => $role)
                            <tr class="border-b text-xs">
                                <td class="px-6 py-3 text-left">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 text-left">{{ $role->name }}</td>
                                <td class="px-6 py-px-4 text-left whitespace-nowrap">
                                    {{ $role->permissions->pluck('name')->implode(" | ") }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    {{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('role.edit', $role->id) }}" class="text-yellow-500 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="deleteRole({{ $role->id }})"
                                        class="text-red-500">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            function deleteRole(id) {
                if (confirm("Are you sure want to delete?")) {
                    $.ajax({
                        url: '{{ route("role.delete") }}',
                        type: 'delete',
                        data: { id: id },
                        dataType: 'json',
                        headers: { 'x-csrf-token': '{{ csrf_token() }}' },
                        success: function () {
                            window.location.href = '{{ route("role.index") }}';
                        }
                    });
                }
            }

            function filterTable() {
                const name = document.getElementById('filter-name').value.toLowerCase();
                const permission = document.getElementById('filter-permission').value.toLowerCase();
                const created = document.getElementById('filter-created').value.toLowerCase();

                const rows = document.querySelectorAll("#role-table tr");

                rows.forEach(row => {
                    const tdName = row.children[1]?.textContent.toLowerCase();
                    const tdPerm = row.children[2]?.textContent.toLowerCase();
                    const tdCreated = row.children[3]?.textContent.toLowerCase();

                    if (
                        tdName.includes(name) &&
                        tdPerm.includes(permission) &&
                        tdCreated.includes(created)
                    ) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
        </script>
    </x-slot>

</x-app-layout>
@endsection
