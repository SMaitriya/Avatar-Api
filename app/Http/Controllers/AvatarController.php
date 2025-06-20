<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function create(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:50',
            'nose_size' => 'required|string|max:50',
            'eye_type' => 'nullable|string|max:50',
            'eye_color' => 'required|string|max:50',
            'eye_size' => 'required|string|max:50',
            'eyebrow_type' => 'required|string|max:50',
            'eyebrow_color' => 'required|string|max:50',
            'hair_type' => 'required|string|max:50',
            'hair_color' => 'required|string|max:50',
            'mouth_type' => 'nullable|string|max:50',
            'mouth_size' => 'required|string|max:50',
            'beard_type' => 'required|string|max:50',
            'beard_color' => 'nullable|string|max:50',
            'shirt_color' => 'required|string|max:50',
            'glasses_type' => 'nullable|string|max:50',
            'accessory_type' => 'nullable|string|max:50',
            'background_type' => 'nullable|string|max:50',
            'skin_color' => 'required|string|max:50',
            'nose_type' => 'required|string|max:50',
        ]);

        // Générer le SVG
        $svgContent = $this->generateSvg($fields);

        // Stocker temporairement
        $tempPath = 'temp_avatars/' . time() . '.svg';
        Storage::disk('public')->put($tempPath, $svgContent);

        return response()->json([
        'svg_url' => url('/storage/' . $tempPath),
            'avatar_data' => $fields
        ]);
    }

    protected function generateSvg(array $fields)
    {
        
        $svg = new \DOMDocument();
        $baseSvgPath = public_path('svg/templates/base.svg');
        if (!file_exists($baseSvgPath)) {
            throw new \Exception('Template SVG manquant');
        }
        $svg->load($baseSvgPath);

    

        $hair = $svg->getElementById('hair');
        $hairPath = public_path("svg/templates/hairs/{$fields['hair_type']}.svg");
        $hairUrl = asset("svg/templates/hairs/{$fields['hair_type']}.svg"); // URL relative
        if ($hair && file_exists($hairPath)) {
            $hair->setAttribute('xlink:href', $hairUrl);
            $hair->setAttribute('fill', $fields['hair_color']);
        }

        return $svg->saveXML();
    
    }
}