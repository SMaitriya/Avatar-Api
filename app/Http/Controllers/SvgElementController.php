<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

// CONTROLLER POUR RECUPERER LES SVG DEPUIS LA BASE DE DONNEES A PARTIR DE L'API

class SvgElementController extends Controller
{
    public function index(): JsonResponse
    {
        $svgElements = Cache::remember('svg_elements_all', now()->addHours(1), function () {
            return DB::table('svg_elements')->get();
        });

        return response()->json($svgElements)
            ->header('Cache-Control', 'public, max-age=3600') // Cache 1 heure
            ->header('Expires', now()->addHour()->toRfc7231String())
            ->header('Last-Modified', now()->toRfc7231String());
    }
}