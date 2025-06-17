<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BibliothequeController extends Controller
{
     public function index()
    {
        return view('bibliotheque');
    }
}
