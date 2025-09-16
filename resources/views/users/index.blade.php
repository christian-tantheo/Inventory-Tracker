@extends('layouts.app')

@section('title')
User List
@endsection

@section('content')
<div class="bg-light rounded">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Users</h5>
            <h6 class="card-subtitle mb-2 text-muted">Manage your users here.</h6>

            <div class="mt-2">
                @include('layouts.includes.messages')
            </div>

            <div class="d-flex justify-content-between mb-3">
                <!-- Dropdown Filter -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="roleFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(request('role'))
                            Filter: {{ ucfirst(request('role')) }}
                        @else
                            Filter by Role
                        @endif
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="roleFilterDropdown">
                        <li><a class="dropdown-item" href="{{ route('users.index') }}">All Users</a></li>
                        <li><hr class="dropdown-divider"></li>
                        {{-- Assuming 'roles' variable is passed from controller for dynamic filtering,
                             otherwise, these are hardcoded as per original view --}}
                        <li><a class="dropdown-item" href="{{ route('users.index', ['role' => 'admin']) }}">Admin</a></li>
                        <li><a class="dropdown-item" href="{{ route('users.index', ['role' => 'user']) }}">Employee</a></li>
                        {{-- If you have a $roles variable from the controller, you could dynamically generate these:
                        @foreach($roles as $role)
                            <li><a class="dropdown-item" href="{{ route('users.index', ['role' => $role->name]) }}">{{ ucfirst($role->name) }}</a></li>
                        @endforeach
                        --}}
                    </ul>
                </div>

                <!-- Add User Button -->
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Add user</a>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" width="1%">#</th>
                        <th scope="col" width="15%">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" width="10%">Username</th>
                        <th scope="col" width="10%">Roles</th>
                        <th scope="col" width="1%" colspan="3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            {{-- Displaying roles as a comma-separated string --}}
                            {{ $user->roles->pluck('name')->implode(', ') }}
                        </td>
                        <td><a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm">Show</a></td>
                        <td><a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a></td>
                        <td>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex">
                {!! $users->appends(request()->query())->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
