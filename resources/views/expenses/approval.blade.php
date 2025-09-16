@extends('layouts.app') {{-- Ensure this extends your main layout --}}

@section('content')
<div class="container mt-4">
    <h2>Expense Approvals</h2>

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
                            <th>Date</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Receipt</th>
                            <th>Requested By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($expenses as $index => $expense)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $expense->title }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>Rp {{ number_format($expense->amount, 2, ',', '.') }}</td>
                                <td>{{ $expense->project ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($expense->date_of_expense)->format('d M Y') }}</td>
                                <td>{{ Str::limit($expense->description, 50, '...') ?? 'N/A' }}</td>
                                <td><span class="badge bg-warning">{{ $expense->status }}</span></td>
                                <td>
                                    @if ($expense->receipt)
                                        <a href="{{ Storage::url($expense->receipt) }}" target="_blank" class="btn btn-sm btn-outline-info">View</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $expense->user->name ?? 'N/A' }}</td> {{-- Assuming 'name' is the user's display name --}}
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <form action="{{ route('expenses.approve', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this expense?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success me-2">Approve</button>
                                        </form>
                                        <form action="{{ route('expenses.reject', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this expense?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">No expenses awaiting approval.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection