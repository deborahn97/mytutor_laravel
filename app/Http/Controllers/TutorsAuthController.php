<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutors;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class TutorsAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'mailing_address' => 'required',
            'state' => 'required',
            'password' => 'required|min:6',
        ]);
        
        $email = $request->only('email');
        $tutors = DB::table('tutors')->where('email', $email)->first();

        if($tutors) {
            return redirect("/")->with('error', 'Failed');
        } else {
            $data = $request->all();
            $check = $this->create($data);
            $check->save();

            return redirect("/")->with('save', 'Success');
        }
    }

    public function create(array $data)
    {
        return Tutors::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'mailing_address' => $data['mailing_address'],
            'state' => $data['state'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('tutors')->attempt($credentials)) {
            return redirect()->intended('subjects-list')->with('save', 'Success');
        } else {
            return redirect("/")->withErrors('error', 'Failed');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
