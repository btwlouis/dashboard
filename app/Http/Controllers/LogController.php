<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index()
    {
        $logs = Activity::all();

        return view('logs.index', compact('logs'));
    }
}
