<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $search = $request->query('search');

        if (empty($search)) {
            return response()->json([]);
        }

        $settlements = Settlement::query()
            ->where('description', 'LIKE', "{$search}%")
            ->limit(20)
            ->get();

        return response()->json($settlements);
    }
}
