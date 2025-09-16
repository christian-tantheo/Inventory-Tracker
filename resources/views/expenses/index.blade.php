@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Expense List</h2>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">Create New +</a>
    </div>

    {{-- Success Message --}}
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

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Expense Title</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Project</th>
                            <th>Description</th>
                            <th>Date of Expense</th>
                            <th>Receipt</th>
                            <th>Requested By</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $index => $expense)
                            <tr>
                                <td>{{ $expenses->firstItem() + $index }}</td>
                                <td>{{ $expense->title }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>Rp {{ number_format($expense->amount, 2, ',', '.') }}</td> {{-- Formatted for IDR with 2 decimals --}}
                                <td>{{ $expense->project ?? 'N/A' }}</td> {{-- Handle null project --}}
                                <td>{{ Str::limit($expense->description, 50, '...') ?? 'N/A' }}</td> {{-- Shorten description and handle null --}}
                                <td>{{ \Carbon\Carbon::parse($expense->date_of_expense)->format('d M Y') }}</td> {{-- Formatted date --}}
                                <td>
                                    @if($expense->receipt)
                                        <a href="{{ Storage::url($expense->receipt) }}" target="_blank" class="btn btn-sm btn-outline-info">View</a> {{-- Using Storage::url --}}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $expense->user->name ?? 'N/A' }}</td> {{-- Assuming 'name' is the user's display name --}}
                                <td>
                                    <span class="badge
                                        @if($expense->status == 'Approved') bg-success
                                        @elseif($expense->status == 'Pending') bg-warning text-dark
                                        @elseif($expense->status == 'Rejected') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ $expense->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">No expenses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Links --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $expenses->appends(request()->except('page'))->links() }}
    </div>
</div>
@endsection