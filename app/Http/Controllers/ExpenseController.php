<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the user's expenses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Eager load the user relationship and paginate the results
        $expenses = Expense::with('user')->orderBy('date_of_expense', 'desc')->paginate(10);
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created expense in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'category'        => 'required|string|max:255',
            'project'         => 'nullable|string|max:255',
            'amount'          => 'required|numeric|min:0',
            'description'     => 'nullable|string',
            'date_of_expense' => 'required|date',
            'receipt'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        try {
            if ($request->hasFile('receipt')) {
                $data['receipt'] = $request->file('receipt')->store('receipts', 'public');
            }

            // Add the authenticated user's ID
            $data['user_id'] = Auth::id();

            Expense::create($data);

            return redirect()->route('expenses.index')->with('success', 'Expense submitted successfully.');
        } catch (Exception $e) {
            Log::error('Failed to store expense: ' . $e->getMessage());

            // If a file was uploaded but the database query failed, delete the orphaned file.
            if (!empty($data['receipt']) && Storage::disk('public')->exists($data['receipt'])) {
                 Storage::disk('public')->delete($data['receipt']);
            }
            
            return redirect()->back()
                ->with('error', 'There was a problem submitting your expense. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display a listing of expenses awaiting approval.
     *
     * @return \Illuminate\View\View
     */
    public function approvalList()
    {
        // Eager-load the user relationship to avoid N+1 issues in the view
        $expenses = Expense::with('user')->where('status', 'Pending')->get();
        return view('expenses.approval', compact('expenses'));
    }

    /**
     * Approve a specified expense.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        try {
            $expense = Expense::findOrFail($id);
            $expense->status = 'Approved';
            $expense->save();

            return back()->with('success', 'Expense approved.');
        } catch (Exception $e) {
            Log::error("Failed to approve expense with ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Could not approve the expense. Please try again.');
        }
    }

    /**
     * Reject a specified expense.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        try {
            $expense = Expense::findOrFail($id);
            $expense->status = 'Rejected';
            $expense->save();

            return back()->with('success', 'Expense rejected.');
        } catch (Exception $e) {
            Log::error("Failed to reject expense with ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Could not reject the expense. Please try again.');
        }
    }
}
