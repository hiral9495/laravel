<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    function index()
    {
        return view('login');
    }

    function registration()
    {
        return view('registration');
    }

    function validate_registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password|min:8'
        ]);
    
        if ($validator->fails()) {
            // Manually flash password fields to the session
            session()->flash('password', $request->password);
            session()->flash('confirmPassword', $request->confirmPassword);
    
            // Redirect back with errors and input except passwords
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
                           //  ->withInput($request->except(['password', 'confirmPassword']));
        }

        $data = $request->all();

        User::create([
            'name'  =>  $data['name'],
            'email' =>  $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return redirect('login')->with('success', 'Registration Completed, now you can login');
    }

    function validate_login(Request $request)
    {
        $request->validate([
            'email' =>  'required',
            'password'  =>  'required'
        ]);

        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials))
        {
            return redirect('dashboard');
        }

        return redirect('login')->with('success', 'Login details are not valid');
    }

    function dashboard()
    {
        if(Auth::check())
        {
            return view('dashboard');
        }

        return redirect('login')->with('success', 'you are not allowed to access');
    }

    function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect('login');
    }

    function profile()
    {
        if(Auth::check())
        {
            $user_id = Auth::user()->id;  
            $detail = [
                'userId' => Auth::user()->id,
                'name'  => Auth::user()->name,
                'email' => Auth::user()->email
            ];
            return view('profile',  ['detail' => $detail]);
        }

        return redirect('login')->with('success', 'you are not allowed to access');
    }

    public function updateProfile(Request $request)
    {

        $user = Auth::user();

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:225',
            'email' =>['required', 'email', Rule::unique('users')->ignore($user->id)],
            // other validation rules
        ]);


        // Update the user's profile
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // update other fields

        // Save the changes
        $user->save();

        // Redirect back with success message
        return response()->json(['success' => 'Profile updated successfully.']);
      //  return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {

        $user = Auth::user();

        // Validate the request
        $validator = Validator::make($request->all(), [

            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password|min:8'
        ]);
    
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            // Manually flash password fields to the session
            session()->flash('password', $request->password);
            session()->flash('confirmPassword', $request->confirmPassword);
    
            // Redirect back with errors and input except passwords
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
                           //  ->withInput($request->except(['password', 'confirmPassword']));
        }


        // Update the user's profile
        $user->password =Hash::make($request->input('password'));
        // update other fields

        // Save the changes
        $user->save();

        // Redirect back with success message
        return response()->json(['success' => 'Profile updated successfully.']);
      //  return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
