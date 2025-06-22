@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-yellow-100 p-6">

        <h2 class="text-2xl font-bold mb-6">Crée ton Avatar</h2>

        <!-- Section principale avatar -->
        <div class="flex items-center justify-center mb-8">
            <!-- Bouton Sauvegarder (à brancher plus tard) -->
            <button
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-full border-2 border-black mr-4">
                Sauvegarder
            </button>

            <!-- Zone d'affichage de l'avatar -->
            <div class="bg-indigo-800 rounded-lg p-6">
                <div class="relative w-64 h-64 flex items-center justify-center">
                    <svg id="avatar-canvas" width="200" height="250" viewBox="0 0 200 250">
                        <!-- Fond tête -->
                        <ellipse cx="100" cy="125" rx="80" ry="100" fill="#FFDAB9" />
                        <!-- Ajout dynamique SVG -->
                        <g id="hair"></g>
                        <g id="eyes"></g>
                        <g id="mouth"></g>
                    </svg>
                </div>
                <!-- Nom de l'avatar -->
                <div contenteditable="true"
                    class="mt-4 text-center bg-yellow-300 py-1 px-3 rounded-md font-semibold text-gray-800">
                    Avatar_1
                </div>
            </div>

            <!-- Bouton Télécharger (SVG) -->
            <button id="download-btn" type="button"
                class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-full border-2 border-black ml-4">
                Télécharger
            </button>
        </div>

        <!-- Barre de modifications (boutons de sélection) -->
        <div class="flex flex-col items-center gap-6">

            <!-- Sélection couleur et partie -->
            <div class="flex items-center gap-4">
                <span class="font-semibold">Colorier&nbsp;:</span>
                <select id="color-target" class="border rounded px-2 py-1">
                    <option value="eyes">Yeux</option>
                    <option value="hair">Cheveux</option>
                </select>
                <input id="color-picker" type="color" value="#4A90E2" class="ml-2 w-10 h-10 border rounded-full">
                <span id="color-value" class="ml-2 font-mono text-gray-600">#4A90E2</span>
            </div>

            <!-- Choix des yeux -->
            <div>
                <span class="font-semibold mr-2">Yeux :</span>
                <button class="bg-white border rounded px-3 py-1 shadow hover:bg-gray-200"
                    onclick="setEyes('basic')">Basic</button>
                <button class="bg-white border rounded px-3 py-1 shadow hover:bg-gray-200"
                    onclick="setEyes('sleep')">Sleep</button>
                <button class="bg-white border rounded px-3 py-1 shadow hover:bg-gray-200"
                    onclick="setEyes('croix')">Croix</button>
            </div>
            <!-- Choix des cheveux -->
            <div>
                <span class="font-semibold mr-2">Cheveux :</span>
                <button class="bg-white border rounded px-3 py-1 shadow hover:bg-gray-200"
                    onclick="setHair('basic')">Court</button>
                <!-- Ajoute d'autres styles ici -->
            </div>
            <!-- Choix de la bouche -->
            <div>
                <span class="font-semibold mr-2">Bouche :</span>
                <button class="bg-white border rounded px-3 py-1 shadow hover:bg-gray-200"
                    onclick="setMouth('smile')">Sourire</button>
                <button class="bg-white border rounded px-3 py-1 shadow hover:bg-gray-200"
                    onclick="setMouth('sad')">Triste</button>
            </div>
        </div>
    </div>

    <script>
        // --------------- Téléchargement du SVG
        document.getElementById('download-btn').addEventListener('click', function() {
            const svg = document.getElementById('avatar-canvas');
            const serializer = new XMLSerializer();
            let source = serializer.serializeToString(svg);
            if (!source.match(/^<svg[^>]+xmlns="http\:\/\/www\.w3\.org\/2000\/svg"/)) {
                source = source.replace(/^<svg/, '<svg xmlns="http://www.w3.org/2000/svg"');
            }
            if (!source.match(/^<svg[^>]+"http\:\/\/www\.w3\.org\/1999\/xlink"/)) {
                source = source.replace(/^<svg/, '<svg xmlns:xlink="http://www.w3.org/1999/xlink"');
            }
            const blob = new Blob([source], {
                type: 'image/svg+xml;charset=utf-8'
            });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = 'avatar.svg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            setTimeout(() => URL.revokeObjectURL(url), 10);
        });

        // -------------------- FONCTIONS DE CHARGEMENT ET COLORISATION

        let currentEyes = 'basic';
        let currentHair = 'basic';

        async function setEyes(type) {
            currentEyes = type;
            const res = await fetch('/svg/templates/eyes/' + type + '.svg');
            const svgText = await res.text();
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = svgText;
            const g = tempDiv.querySelector('g');
            document.getElementById('eyes').innerHTML = g ? g.outerHTML : svgText;
            if (document.getElementById('color-target').value === 'eyes') recolorElement('eyes');
        }
        async function setMouth(type) {
            const res = await fetch('/svg/templates/mouth/' + type + '.svg');
            const svgText = await res.text();
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = svgText;
            const g = tempDiv.querySelector('g');
            document.getElementById('mouth').innerHTML = g ? g.outerHTML : svgText;
        }
        async function setHair(type) {
            currentHair = type;
            const res = await fetch('/svg/templates/hair/' + type + '.svg');
            const svgText = await res.text();
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = svgText;
            const g = tempDiv.querySelector('g');
            document.getElementById('hair').innerHTML = g ? g.outerHTML : svgText;
            if (document.getElementById('color-target').value === 'hair') recolorElement('hair');
        }

        // ---- Coloration dynamique
        function recolorElement(part) {
            const color = document.getElementById('color-picker').value;
            if (part === 'eyes' && document.getElementById('eyes')) {
                document.querySelectorAll('#eyes [fill="#4A90E2"], #eyes .iris').forEach(el => {
                    el.setAttribute('fill', color);
                });
            }
            if (part === 'hair' && document.getElementById('hair')) {
                document.querySelectorAll('#hair .hair').forEach(el => {
                    el.setAttribute('fill', color);
                });
            }
        }
        // Change la couleur en live
        document.getElementById('color-picker').addEventListener('input', function() {
            document.getElementById('color-value').textContent = this.value;
            recolorElement(document.getElementById('color-target').value);
        });
        // Change la partie à colorier
        document.getElementById('color-target').addEventListener('change', function() {
            recolorElement(this.value);
        });

        // -------------- INIT
        setEyes('basic');
        setMouth('smile');
        setHair('basic');
    </script>
@endsection
