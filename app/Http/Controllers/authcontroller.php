<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authcontroller extends Controller
{
    public function index(){
        return view('Profile',['data'=>auth()->user()]);
    }
    public function show(){
        return view('Signin');
    }
    public function login(Request $request){
        $vali=$request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        
        if(Auth::attempt($vali)){
            $request->session()->regenerate();
            return redirect("/");
        }
            return back()->withErrors(["login"=>"email or password incorrect"]);
    }
    public function create(){
        return view('Signup');
    }
    public function register(Request $request){
        $vali=$request->validate([
            'firstName'=>'required|min:3',
            'lastName'=>'required|min:3',
            'tel'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:6'
        ]);
        $vali["password"]=Hash::make($vali["password"]);
        $vali['role']='manager';
        $user=User::create($vali);
        logAction('User_created',$user->id, 'User', $user->id, json_encode($user));
        Auth::login($user);
        return redirect()->route('home');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'tel' => 'nullable|string|max:20',
            'oldPassword' => 'nullable|string|min:6',
            'newPassword' => 'nullable|string|min:6|different:oldPassword',
            'confirmednewpassword' => 'nullable|same:newPassword',
        ]);
        $user = auth()->user();
        if ($user->firstName !== $validatedData['firstName'] || $user->lastName !== $validatedData['lastName']) {
            $user->firstName = $validatedData['firstName'];
            $user->lastName = $validatedData['lastName'];
        }
        if ($user->tel !== $validatedData['tel']) {
            $user->tel = $validatedData['tel'];
        }
        if ($validatedData['oldPassword'] && password_verify($validatedData['oldPassword'], $user->password)) {
            if ($validatedData['newPassword']) {
                $user->password = Hash::make($validatedData['newPassword']);
            }
        }
        $user->save();
        logAction('User_updated', $user->id, 'User', $user->id, json_encode($user));
        return back()->with('success', 'Profile updated successfully!');
    }
    
}
