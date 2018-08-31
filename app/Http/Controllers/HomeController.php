<?php

namespace App\Http\Controllers;

use App\Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * View the form for reporting a User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewReportForm() {
        return view('report');
    }

    /**
     * Report a User/Player
     *
     * @param Request $request
     * @return \Illuminate\Support\MessageBag
     */
    public function reportUser(Request $request) {
        // Validate Request
        $validator = Validator::make($request->all(), [
            'reported_user' => 'required|string|exists:users,username',
            'reportee_id' => 'required|integer|exists:users,id',
            'reason' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // Check if the User is spamming
        //todo

        // Submit the Report
        Reports::create([
            'reported_username' => $request->get('reported_user'),
            'reportee_id' => $request->get('reportee_id'),
            'reason' => $request->get('reason')
        ]);

        return response('Success', 200);
    }
}
