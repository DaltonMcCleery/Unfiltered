<?php

namespace App\Http\Controllers;

use App\Stats;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Update a User's details
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Illuminate\Support\MessageBag
     */
    public function updateProfile(Request $request) {
        // Validate Request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|alpha_dash',
            'email' => 'required|email',
            'password' => 'nullable|string',
            'password_confirmation' => 'required_with:password|same:password'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user_id = $request->get('user_id');

        // Check that the Username isn't already taken
        $check = User::where('username', $request->get('username'))
            ->where('id', '!=', $user_id)
            ->exists();

        if ($check) {
            // Username is already taken
            return response(['The username has already been taken']);
        }

        // Update User details
        User::where('id', $user_id)
            ->update([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email' => $request->get('email')
            ]);

        // Check for password changes
        if ($request->has('password')) {
            User::where('id', $user_id)
                ->update([
                    'password' => bcrypt($request->get('password'))
                ]);
        }

        return response('Updated', 200);
    }

    public function validateProfile($request) {

    }
}
