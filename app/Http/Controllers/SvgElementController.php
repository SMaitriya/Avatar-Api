<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class SvgElementController extends Controller
{
    /**
     * Retourne tous les éléments SVG en JSON, avec mise en cache serveur (6h)
     */
    public function index(): JsonResponse
    {
        // On met tout le résultat en cache pour 6h, ça accélère beaucoup !
        $svgElements = Cache::remember('svg_elements_all', now()->addHours(6), function () {
            return DB::table('svg_elements')->get();
        });

        return response()->json($svgElements);
    }
}
