<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avatar;

class BibliothequeController extends Controller
{
     public function index()
    {
        return view('bibliotheque');
    }

}
