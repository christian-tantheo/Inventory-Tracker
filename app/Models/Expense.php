<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Add 'user_id' to this array
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'project',
        'amount',
        'description',
        'date_of_expense',
        'receipt',
        'status', // Assuming 'status' is also fillable
    ];

    /**
     * Get the user that owns the expense.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}