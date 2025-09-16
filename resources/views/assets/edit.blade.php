@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Asset</h2>

    {{-- General success/error messages from the session --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="asset_id" class="form-label">Asset ID</label>
            <input type="text" name="asset_id" id="asset_id" class="form-control @error('asset_id') is-invalid @enderror" value="{{ old('asset_id', $asset->asset_id) }}" required>
            @error('asset_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Asset Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $asset->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $asset->category) }}" required>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="condition" class="form-label">Condition</label>
            <select name="condition" id="condition" class="form-select @error('condition') is-invalid @enderror" required>
                <option value="Used" {{ old('condition', $asset->condition) == 'Used' ? 'selected' : '' }}>Used</option>
                <option value="New" {{ old('condition', $asset->condition) == 'New' ? 'selected' : '' }}>New</option>
                <option value="Damaged" {{ old('condition', $asset->condition) == 'Damaged' ? 'selected' : '' }}>Damaged</option>
            </select>
            @error('condition')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assigned To</label>
            <input type="text" name="assigned_to" id="assigned_to" class="form-control @error('assigned_to') is-invalid @enderror" value="{{ old('assigned_to', $asset->assigned_to) }}" required>
            @error('assigned_to')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="purchase_date" class="form-label">Purchase Date</label>
            <input type="date" name="purchase_date" id="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', $asset->purchase_date) }}" required>
            @error('purchase_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="Active" {{ old('status', $asset->status) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Maintenance" {{ old('status', $asset->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="Archived" {{ old('status', $asset->status) == 'Archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="attachment" class="form-label">Attachment</label>
            @if($asset->attachment)
                <div class="mb-2">
                    <a href="{{ Storage::url($asset->attachment) }}" target="_blank">
                        View Current File
                    </a>
                </div>
            @endif

            <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
            @error('attachment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text text-muted">Upload a new file to replace the current one.</div>
        </div>

        <button type="submit" class="btn btn-success">Update Asset</button>
        <a href="{{ route('assets.index') }}" class="btn btn-secondary ms-2">Cancel</a> {{-- Added a cancel button --}}
    </form>
</div>
@endsection