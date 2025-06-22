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
            'eye_type' => 'required|string|max:50',
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
        $this->addEyes($svg, $fields);
        $this->setSkinColor($svg, $fields['skin_color']);
        $this->addMouth($svg, $fields);



        return $svg->saveXML();
    }
    /**
     * @param \DOMDocument $doc
     * @param string $id
     * @return \DOMElement|null
     */
    protected function getElementById(\DOMDocument $doc, string $id)
    {
        $xpath = new \DOMXPath($doc);
        return $xpath->query("//*[@id='$id']")->item(0);
    }


    protected function setSkinColor(\DOMDocument $svg, string $color)
    {
        $faceElement = $this->getElementById($svg, 'face');
        if ($faceElement) {
            $faceElement->setAttribute('fill', $color);
        }
    }


    protected function addEyes(\DOMDocument $svg, array $fields)
    {

        $eyesContainer = $this->getElementById($svg, 'eyes');
        if (!$eyesContainer) return;

        $eyesPath = public_path("svg/templates/eyes/{$fields['eye_type']}.svg"); // modifie le champ 'eye_type'
        if (!file_exists($eyesPath)) return;

        $eyesSvg = new \DOMDocument();
        $eyesSvg->load($eyesPath);
        $eyesSvg->preserveWhiteSpace = false;
        $eyesSvg->formatOutput = true;

        $eyeId = $fields['eye_type'] . '-eyes'; // ex : croix-eyes, sleepy-eyes, etc.
        $eyesElements = $this->getElementById($eyesSvg, $eyeId);

        if ($eyesElements) {
            $importedEyes = $svg->importNode($eyesElements, true);
            $eyesContainer->appendChild($importedEyes);
        }
    }

    protected function addMouth(\DOMDocument $svg, array $fields)
    {
        $mouthContainer = $this->getElementById($svg, 'mouth');
        if (!$mouthContainer) return;

        $mouthPath = public_path("svg/templates/mouth/{$fields['mouth_type']}.svg");
        if (!file_exists($mouthPath)) return;

        $mouthSvg = new \DOMDocument();
        $mouthSvg->load($mouthPath);
        $mouthSvg->preserveWhiteSpace = false;
        $mouthSvg->formatOutput = true;

        $mouthId = $fields['mouth_type'] . '-mouth';
        $mouthElements = $this->getElementById($mouthSvg, $mouthId);

        if ($mouthElements) {
            $importedMouth = $svg->importNode($mouthElements, true);
            $mouthContainer->appendChild($importedMouth);
        }
    }
}
