<?php

namespace App\Http\Controllers;

use App\Models\PpeViolation;
use Illuminate\Contracts\View\View;

class ViolationReportController extends Controller
{
    /**
     * Display the printable HSE incident report for a violation.
     */
    public function show(PpeViolation $violation): View
    {
        return view('violations.report', [
            'violation' => $violation,
        ]);
    }
}
