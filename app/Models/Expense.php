<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'amount',
        'user_id',
        'entry_date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(related: Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }
}
