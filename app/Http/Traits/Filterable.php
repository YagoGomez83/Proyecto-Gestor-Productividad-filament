<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait Filterable
{
    protected function applyDateFilters($query, Request $request)
    {
        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }
        
        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }
        
        return $query;
    }
}