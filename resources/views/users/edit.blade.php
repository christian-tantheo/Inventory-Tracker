@extends('layouts.app')

@section('title')
Edit User
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update user</h5>

            <div class="container mt-4">
                <form method="post" action="{{ route('users.update', $user->id) }}">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input value="{{ old('first_name', explode(' ', $user->name, 2)[0]) }}"
                            type="text"
                            class="form-control"
                            name="first_name"
                            placeholder="First Name" required>

                        @if ($errors->has('first_name'))
                            <span class="text-danger text-left">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input value="{{ old('last_name', isset(explode(' ', $user->name, 2)[1]) ? explode(' ', $user->name, 2)[1] : '') }}"
                            type="text"
                            class="form-control"
                            name="last_name"
                            placeholder="Last Name" required>

                        @if ($errors->has('last_name'))
                            <span class="text-danger text-left">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input value="{{ old('email', $user->email) }}"
                            type="email"
                            class="form-control"
                            name="email"
                            placeholder="Email address" required>
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input value="{{ old('username', $user->username) }}"
                            type="text"
                            class="form-control"
                            name="username"
                            placeholder="Username" required>
                        @if ($errors->has('username'))
                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                            class="form-control"
                            name="password"
                            placeholder="Leave blank to keep current password">
                        @if ($errors->has('password'))
                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password"
                            class="form-control"
                            name="password_confirmation"
                            placeholder="Confirm new password">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control"
                            name="role" required>
                            <option value="">Select role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ in_array($role->name, $userRole) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                            <span class="text-danger text-left">{{ $errors->first('role') }}</span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update user</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
