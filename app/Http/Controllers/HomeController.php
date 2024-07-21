<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function formValidation()

    {

        return view('form-validation');
    }


    public function formValidationPost(Request $request)

    {

        $this->validate($request, [

            'firstname' => 'required|min:5|max:35',

            'lastname' => 'required|min:5|max:35',

            'email' => 'required|email|unique:users',

            'mobileno' => 'required|numeric',

            'password' => 'required|min:3|max:20',

            'confirm_password' => 'required|min:3|max:20|same:password',

            'details' => 'required'

        ], [

            'firstname.required' => ' The first name field is required.',

            'firstname.min' => ' The first name must be at least 5 characters.',

            'firstname.max' => ' The first name may not be greater than 35 characters.',

            'lastname.required' => ' The last name field is required.',

            'lastname.min' => ' The last name must be at least 5 characters.',

            'lastname.max' => ' The last name may not be greater than 35 characters.',

        ]);


        dd('You are successfully added all fields.');
    }
}
