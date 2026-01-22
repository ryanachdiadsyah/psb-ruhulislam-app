<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TimelineService;


class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $timeline = TimelineService::forUser($request->user());
        return view('app.dashboard', [
            'onboarding' => auth()->user()->onboarding,
            'timeline'   => $timeline,
        ]);
    }
}
