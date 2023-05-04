<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        if (session()->exists("users")) {
            return redirect("/userdashboard");
        }
        return view('welcome');
    }
}
