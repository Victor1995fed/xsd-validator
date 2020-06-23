<?php

namespace App\Http\Controllers;

use App\Xsd;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $countXsd = Xsd::count();
         return view('main.index', [
             'countXsd' => $countXsd
         ]);
    }
}
