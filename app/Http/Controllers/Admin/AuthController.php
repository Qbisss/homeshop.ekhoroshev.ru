<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function check()
    {
        if(Auth::guard('admin')->check())
            return redirect(route("admin.panel.index"));

        return $this->index();
    }
    public function index()
    {

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "login" => ["required", "string"],
            "password" => ["required"]
        ]);

        if(auth("admin")->attempt($data)){
            return redirect(route("admin.panel.index"));
        }

        return redirect(route("admin.login"))->withErrors(["login" => "Пользователь не найден"]);
    }

    public function logout()
    {
        auth("admin")->logout();

        return redirect(route('home'));
    }
}
