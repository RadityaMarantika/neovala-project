@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-base text-gray-800 leading-tight">
                Profile Settings
            </h2>
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User Access Info</h6>
                    </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- User Access Info -->
            <div class="col-md-6 mb-4">
                <div class="card shadow border-left-primary">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User Access Info</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Password:</strong> <em>(Tersimpan secara terenkripsi)</em></p>
                        <hr>
                        <p><strong>Role:</strong> {{ $user->getRoleNames()->implode(', ') ?: 'Tidak ada role' }}</p>
                        <hr>
                        <strong>Permissions:</strong>
                        @php
                            $permissionList = $user->getAllPermissions()->pluck('name')->toArray();
                            $chunks = array_chunk($permissionList, ceil(count($permissionList) / 4));
                        @endphp

                        @if (empty($permissionList))
                            <p class="text-muted">Tidak ada permissions</p>
                        @else
                            <div class="row">
                                @foreach ($chunks as $col)
                                    <div class="col-md-3">
                                        <ol class="pl-0">
                                            @foreach ($col as $permission)
                                                <li>{{ $permission }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Forms Column -->
            <div class="col-md-6 mb-4">
                <!-- Toggle Buttons -->
                <div class="mb-3">
                    <button class="btn btn-info btn-sm mr-2" onclick="toggleForm('updateInfoForm')">Update Name & Email</button>
                    <button class="btn btn-warning btn-sm" onclick="toggleForm('updatePasswordForm')">Update Password</button>
                </div>

                <!-- Update Name and Email -->
                <div id="updateInfoForm" class="card shadow border-left-info mb-4 d-none">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Update Name and Email</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="form-control" required>
                                <x-input-error :messages="$errors->get('name')" class="mt-1 text-danger" />
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                                <x-input-error :messages="$errors->get('email')" class="mt-1 text-danger" />
                            </div>

                            <button type="submit" class="btn btn-info">Save</button>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div id="updatePasswordForm" class="card shadow border-left-warning d-none">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Update Password</h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input id="current_password" name="current_password" type="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input id="password" name="password" type="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-warning">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Toggle Script -->
    <script>
        function toggleForm(formId) {
            const forms = ['updateInfoForm', 'updatePasswordForm'];
            forms.forEach(id => {
                const el = document.getElementById(id);
                if (id === formId) {
                    el.classList.toggle('d-none');
                } else {
                    el.classList.add('d-none');
                }
            });
        }
    </script>
</x-app-layout>
@endsection
