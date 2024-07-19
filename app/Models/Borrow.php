<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'user_id'];

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
        $borrowDate = $this->created_at;
        $currentDate = Carbon::now();

        
        $penaltyPerDay = 10000;
        $totalBookBorrowed = $this->books()->count();

        $dueDate = $borrowDate->addDays(7);
        $daysOverdue = floor($dueDate->diffInDays($currentDate));
        $isOverdue = $daysOverdue > 0;

        return $isOverdue ?  $daysOverdue * ($totalBookBorrowed * $penaltyPerDay) : null;
    }
}
