<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
    'asset_id',
    'name',
    'category',
    'condition',
    'assigned_to',
    'purchase_date',
    'status',
    'attachment',
];


}
