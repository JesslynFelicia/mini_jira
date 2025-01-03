<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        // dd($request->session()->get('curruser')->toArray());
        // dump($request);
        session()->forget('login_failed');
     
        $checkuser = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if ($checkuser) {
            //   dump("berhasil");
           $checkuser = Auth::user();
            $request->session()->put('curruser', $checkuser);
            // dd($request->session()->get('curruser')->toArray());
            return redirect()->route('home');
        } else if ($request && !empty($request->input('email')[0])) {
            // dump("berhasil else");
            session()->put('login_failed', true);
            // session()->flash('alert', 'Request is invalid or missing.');

        }


        return view('auth.login');
    }

    public function logout(Request $request){
        // dd("tes");
                $request->session()->pull('curruser');
        // dd($request->session()->get('curruser')->toArray());
        return view('auth.login');
    }

    public function register (Request $request){

        // dd($request);
        if (empty($request->input('email')[0])){
            return view ('auth.register');
        }
        $validatedData = $request->validate([
            'name' => 'required|min:2', // Name must be at least 2 characters
            'email' => 'required|email', // Email must be valid and contain '@'
            'password' => 'required|min:6', // Password must be at least 6 characters
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); // Hash the password
        $user->save();
    
        // Redirect or return response after successful registration
        return redirect()->route('login')->with('success', 'Registration successful!');

    }
}
