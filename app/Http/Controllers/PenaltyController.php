<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Penalty;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function all(Request $request)
    {
        try {
            $query = Penalty::latest();

            $startDate = $request->query('startDate');
            $endDate = $request->query('endDate');

            if ($startDate && $endDate) {
                $dateRange = [$startDate, $endDate];
                $query->whereBetween('created_at', $dateRange);
            } else if ($startDate) {
                $query->where('created_at', $startDate);
            }

            $penalties = $query->get();

            $message = $penalties->isNotEmpty() ? 'Penalty found' : 'Penalty not found';
            
            return ResponseHelper::returnOkResponse($message, $penalties);
        }catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }

    public function detail(Penalty $penalty)
    {
        try {
            return ResponseHelper::returnOkResponse('Penalty found', $penalty);
        } catch (\Exception $exception) {
            return ResponseHelper::throwInternalError($exception->getMessage());
        }
    }
}
