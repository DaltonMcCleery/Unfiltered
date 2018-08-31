<?php

namespace App\Http\Controllers;

use App\Stats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NinjaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the Ninja's Profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stats = Stats::where('ninja_id', Auth::user()->id)->first();
        return view('ninja.profile', [
            'stats' => $stats
        ]);
    }
}
