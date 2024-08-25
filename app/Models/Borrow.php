<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Borrow extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function penalty()
    {
        return $this->hasOne(Penalty::class);
    }

    public function borrowStatus()
    {
        return $this->belongsTo(BorrowStatus::class);
    }

    public function getPenaltyFee(): ?int
    {
        $borrowDate = Carbon::parse($this->created_at);        
        $currentDate = Carbon::now();
        
        $penaltyPerDay = 10000;
        $totalBookBorrowed = $this->books()->count();
        
        $dueDay = (int) env('APP_BORROW_DUE_DAY', 7);
        $dueDate = $borrowDate->addDays($dueDay);
        $daysOverdue = $dueDate->lessThan($currentDate) ? max(1, $dueDate->diffInDays($currentDate)) : 0;
        $isOverdue = $daysOverdue > 0;
        
        return $isOverdue ?  $daysOverdue * ($totalBookBorrowed * $penaltyPerDay) : null;
    }
}
