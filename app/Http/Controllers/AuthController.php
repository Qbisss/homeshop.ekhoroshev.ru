<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Order;

class AuthController extends Controller
{
    public function index_login()
    {
        if(Auth::check())
        {
            $orders = Order::where('userid', Auth::id())->get();

            return view('personal.orders', ['orders' => $orders]);
        }

        return view('login');
    }

    public function index_register()
    {
        if(Auth::check())
            return redirect('/');

        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/(8)[0-9]{10}/',
            'email' =>'required|email|unique:users',
            'password' => 'required|min:6',
            'password2' => 'required|min:6',
        ]);

        $password = $request->password;
        $password2 = $request->password2;
        if($password != $password2)
        {
            return back()->withErrors([
                'password' => 'Не совпадают пароли'
            ])->onlyInput('password');
        }

        $phone = $request->phone;
        $email = $request->email;

        $user = new User;
        $user->phone = $phone;
        $user->email =$email;
        $user->password = Hash::make($password);
        $user->save();

        return view('registered');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials, $request->checkbox))
        {
            $user = Auth::user();
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Неправильно введен Email или пароль'
        ])->onlyInput('email');
    }
}
