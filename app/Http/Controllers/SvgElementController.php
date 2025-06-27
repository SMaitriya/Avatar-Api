<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;


class SvgElementController extends Controller
{
    // Retourne tous les éléments SVG stockés en base de données
    public function index(): JsonResponse
    {
        $svgElements = DB::table('svg_elements')->get();

           return response()->json($svgElements);
    }
}
