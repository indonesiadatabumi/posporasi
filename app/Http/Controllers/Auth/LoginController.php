<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'super_admin':
                    return redirect()->intended('/super-admin/dashboard');
                case 'owner':
                    return redirect()->intended('/'); 
                case 'pegawai':
                    return redirect()->intended('/pegawai/dashboard'); //ga bisa nyimpen data tapi masuk, naitnya si itu ini manage tokonya kaya buat edit edit gitu, tapi buat nampilin nama tokonya pake card yg bisa di pencet view
                default:    
                    return redirect()->intended('/'); 
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::logout();  
        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
