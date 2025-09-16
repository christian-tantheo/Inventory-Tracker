@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Assets</h2>
        <a href="{{ route('assets.create') }}" class="btn btn-primary">+ Add Asset</a>
    </div>

    {{-- Success Message --}}
    {{-- Moved here to be more prominent at the top after actions --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Error Message --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('assets.index') }}" method="GET" class="d-flex flex-wrap align-items-center">
                <div class="flex-grow-1 me-2 mb-2 mb-md-0">
                    <input type="text" name="search" class="form-control" placeholder="Search by asset name..." value="{{ request('search') }}">
                </div>
                <div class="d-flex">
                    <button type="submit" class="btn btn-dark me-2">Search</button>
                    <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>


    {{-- Assets Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Asset ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Condition</th>
                            <th>Assigned To</th>
                            <th>Purchase Date</th>
                            <th>Status</th>
                            <th>Attachment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assets as $index => $asset)
                            <tr>
                                <td>{{ $assets->firstItem() + $index }}</td>
                                <td>{{ $asset->asset_id }}</td>
                                <td>{{ $asset->name }}</td>
                                <td>{{ $asset->category }}</td>
                                <td>{{ $asset->condition }}</td>
                                <td>{{ $asset->assigned_to }}</td>
                                <td>{{ \Carbon\Carbon::parse($asset->purchase_date)->format('d M Y') }}</td>
                                <td>
                                    <span class="badge
                                        {{ $asset->status == 'Active' ? 'bg-success' : ($asset->status == 'Maintenance' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ $asset->status }}
                                    </span>
                                </td>
                                <td>
                                    @if ($asset->attachment)
                                        <a href="{{ Storage::url($asset->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">No assets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $assets->appends(request()->except('page'))->links() }}
    </div>

</div>
@endsection