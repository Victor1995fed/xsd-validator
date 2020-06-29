<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Xsd;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
         return view('main.index', [
             'countXsd' => Xsd::count(),
             'countUsers' => User::count()
         ]);
    }

    public function help()
    {
        return view('main.help', [

        ]);
    }
}
