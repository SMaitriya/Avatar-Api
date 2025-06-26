@extends('layouts.app')

@section('content')
    <style>
        body,
        h2,
        {
        font-family: 'Poppins', sans-serif;
        }

        .min-h-screen {
            background-color: #f5e8c7;
        }

        button {
            transition: transform 0.2s ease, background-color 0.2s ease;
            border-radius: 0.5rem;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .cursor-pointer:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        .avatar-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            /* Réduit de 1.5rem à 1rem */
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #avatar-canvas {
            background: none;
            overflow: visible;
        }

        .option-card {
            background: #f9fafb;
            border-radius: 0.5rem;
            padding: 0.5rem;
            transition: background-color 0.2s ease;
        }

        .option-card:hover {
            background: #e5e7eb;
        }

        input[type="color"] {
            width: 40px !important;
            height: 40px !important;
            border: none;
            padding: 0;
            background: none;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.07);
        }

        .svg-option {
            width: 120px !important;
            height: 120px !important;
            min-width: 120px !important;
            min-height: 120px !important;
        }

        .options-wrapper {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .options-container {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex-grow: 1;
        }

        .options-container .flex-wrap {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding-left: 0;
        }

        .options-container .flex-wrap::-webkit-scrollbar {
            height: 6px;
        }

        .options-container .flex-wrap::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 3px;
        }

        .part-selector {
            background: #e5e7eb;
            padding: 0.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            width: 120%;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            overflow: hidden;
        }

        .part-selector:hover {
            background: #d1d5db;
        }

        .part-selector.active {
            background: #00AFF5;
            color: white;
        }

        .part-label {
            font-size: 0.75rem;
            text-align: center;
            margin-top: 0.35rem;
            color: #333;
        }

        #color-picker-container {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;

        }

        #color-value {
            font-size: 1rem;
            color: #333;
        }
    </style>

    <div class="flex flex-col items-center justify-center min-h-screen p-4"> <!-- Réduit de p-6 à p-4 -->
        <!-- Section principale avatar -->
        <div class="flex items-center justify-center mb-6 gap-4"> <!-- Réduit mb-8 à mb-6 -->
            <button onclick="sauvegarder()" id="sauvegarder-avatar"
                class="bg-[#00AFF5] hover:bg-[#00BFFF] text-white font-semibold py-2 px-6 rounded-full border-2 border-black"
                style="background-color: #00AFF5; opacity: 1;" aria-label="Sauvegarder l'avatar">
                Sauvegarder
            </button>

            <div class="avatar-container relative" style="width: 250px; height: 280px;">
                <svg id="avatar-canvas" width="300" height="300" viewBox="0 0 190 300"
                    style="display: block; margin: auto;">

                    <g id="background"></g>
                    <g id="haut"></g>
                    <g id="visage"></g>
                    <g id="nez"></g>
                    <g id="bouche"></g>
                    <g id="yeux"></g>
                    <g id="sourcils"></g>
                    <g id="cheveux"></g>
                    <g id="barbe"></g>
                    <g id="accessoire"></g>
                    <g id="lunettes"></g>
                </svg>
                <div id="avatar-name" contenteditable="true"
                    class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-center bg-yellow-300 py-1 px-3 rounded-md font-semibold text-gray-800"
                    style="margin-bottom: -.5rem; min-width: 140px; max-width: 220px; width: max-content; margin-top: 0.5rem; font-size: 1rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                    aria-label="Nom de l'avatar">
                    Avatar_1
                </div>
            </div>

            <button id="download-btn" type="button"
                class="bg-[#FF9800] hover:bg-[#FFA726] text-white font-semibold py-2 px-6 rounded-full border-2 border-black"
                style="background-color: #FF9800; opacity: 1;" aria-label="Télécharger l'avatar">
                Télécharger
            </button>
        </div>

        <!-- Barre de modifications -->
        <div class="w-full max-w-4xl bg-white p-4 rounded-lg shadow-lg"> <!-- Réduit p-6 à p-4 -->
            <div class="flex gap-2 mb-4" id="part-selectors">
                <!-- Visage -->
                <button data-part="visage" class="part-selector">
                    <svg id="visage-icon" width="100" height="100" viewBox="0 0 200 200">
                        <g id="visage"></g>
                    </svg>
                    <span class="part-label">Visage</span>
                </button>
                <!-- Yeux -->
                <button data-part="yeux" class="part-selector">
                    <svg id="yeux-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="yeux"></g>
                    </svg>
                    <span class="part-label">Yeux</span>
                </button>
                <!-- Nez -->
                <button data-part="nez" class="part-selector">
                    <svg id="nez-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="nez"></g>
                    </svg>
                    <span class="part-label">Nez</span>
                </button>
                <!-- Bouche -->
                <button data-part="bouche" class="part-selector">
                    <svg id="bouche-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="bouche"></g>
                    </svg>
                    <span class="part-label">Bouche</span>
                </button>
                <!-- Sourcils -->
                <button data-part="sourcils" class="part-selector">
                    <svg id="sourcils-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="sourcils"></g>
                    </svg>
                    <span class="part-label">Sourcils</span>
                </button>
                <!-- Cheveux -->
                <button data-part="cheveux" class="part-selector">
                    <svg id="cheveux-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="cheveux"></g>
                    </svg>
                    <span class="part-label">Cheveux</span>
                </button>
                <!-- Barbe -->
                <button data-part="barbe" class="part-selector">
                    <svg id="barbe-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="barbe"></g>
                    </svg>
                    <span class="part-label">Barbe</span>
                </button>
                <!-- Lunettes -->
                <button data-part="lunettes" class="part-selector">
                    <svg id="lunettes-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="lunettes"></g>
                    </svg>
                    <span class="part-label">Lunettes</span>
                </button>
                <!-- Accessoire -->
                <button data-part="accessoire" class="part-selector">
                    <svg id="accessoire-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="accessoire"></g>
                    </svg>
                    <span class="part-label">Accessoire</span>
                </button>
                <!-- Background -->
                <button data-part="background" class="part-selector">
                    <svg id="background-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="background"></g>
                    </svg>
                    <span class="part-label">Arrière-plan</span>
                </button>
                <!-- Haut -->
                <button data-part="haut" class="part-selector">
                    <svg id="haut-icon" width="70" height="70" viewBox="0 0 200 200">
                        <g id="haut"></g>
                    </svg>
                    <span class="part-label">Haut</span>
                </button>
            </div>
            <div class="options-wrapper">
                <div class="options-container">
                    <div class="flex gap-2 flex-wrap" id="options-preview"></div>
                </div>

            </div>
            <div class="flex justify-center mt-6">
                <div id="color-picker-container" class="flex items-center gap-2">
                    <input type="color" id="color-picker" value="#FD1353" title="Couleur de l'élément sélectionné">
                    <span id="color-value">#FD1353</span>
                </div>
            </div>

        </div>

        <div class="d-flex justify-content-center mt-3 mb-4 gap-2">
            <input type="color" id="color-picker" value="#4A90E2" style="height:40px;width:40px;border:none;">
            <span id="color-value">#4A90E2</span>
            <select id="color-target" class="form-select w-auto">
                <option value="cheveux">Cheveux</option>
                <option value="yeux">Yeux</option>
                <option value="barbe">Barbe</option>
                <option value="sourcils">Sourcils</option>
                <option value="haut">T-shirt</option>
                <option value="background">Fond</option>
                <option value="visage">Peau</option>
            </select>
            <button id="download-btn" class="btn btn-primary ms-3">Télécharger mon avatar SVG</button>
        </div>

        <div id="choices-area" class="my-4" style="display:grid;gap:28px;"></div>
    </div>
@endsection

@section('scripts')
    <script>
        let svgElements = [];
        let selectedParts = {};
        let currentPart = 'visage';

        const colorSelectors = {
            'visage': ['path[data-part="visage"]', 'fill'],
            'lunettes': ['circle[data-part="lunettes_1"], path[data-part="lunettes_2"]', 'fill'],
            'sourcils': ['path[data-part="sourcils_1"], path[data-part="sourcils_2"], path[data-part="sourcils_3"]',
                'fill'
            ],
            'yeux': ['path[data-part="yeux_1"], path[data-part="yeux_2"], path[data-part="yeux_3"]', 'fill'],
            'haut': ['path[data-part="haut"]', 'fill'],
            'barbe': ['path[data-part="barbe_1"], path[data-part="barbe_2"], polygon[data-part="barbe_1"]', 'fill'],
            'cheveux': ['path[data-part="cheveux_1"], path[data-part="cheveux_2"]', 'fill']
        };

        async function loadSvgElements() {
            const cachedData = sessionStorage.getItem('svgElements');
            if (cachedData) {
                svgElements = JSON.parse(cachedData);
                initializePartIcons();
                return;
            }
            const res = await fetch('/api/svg-elements');
            svgElements = await res.json();
            sessionStorage.setItem('svgElements', JSON.stringify(svgElements));
            initializePartIcons();
        }

        function initializePartIcons() {
            const parts = ['visage', 'yeux', 'nez', 'bouche', 'sourcils', 'cheveux', 'barbe', 'lunettes', 'accessoire',
                'background', 'haut'
            ];
            parts.forEach(part => {
                const element = svgElements.find(e => e.element_type === part);
                if (element) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(element.svg_content, 'image/svg+xml');
                    const svgContent = doc.documentElement;
                    const g = document.getElementById(`${part}-icon`).querySelector('g');
                    const defs = svgContent.querySelector('defs');
                    if (defs) defs.remove();
                    g.innerHTML = svgContent.innerHTML;
                }
            });
        }

        function changePartColor(partName, color) {
            const partElement = document.getElementById(partName);
            if (!partElement || !colorSelectors[partName]) return;

            const [selector, attribute] = colorSelectors[partName];
            const elements = partElement.querySelectorAll(selector);

            elements.forEach(element => {
                if (element.getAttribute(attribute) || elements.length === 1) {
                    element.setAttribute(attribute, color);
                }
            });

            if (elements.length === 0) {
                const fallbackElements = partElement.querySelectorAll('path, circle, ellipse, rect');
                if (fallbackElements.length > 0) {
                    fallbackElements[0].setAttribute(attribute, color);
                }
            }
        }

        async function renderSvgPreviews(part) {
            const container = document.getElementById('options-preview');
            container.innerHTML = '';
            const elements = svgElements.filter(e => e.element_type === part);

            // Bouton "Aucun"
            // Affiche le bouton "Aucun" sauf pour "visage" et "haut"
            if (part !== 'visage' && part !== 'haut') {
                const noneBtn = document.createElement('div');
                noneBtn.classList.add('flex', 'items-center', 'justify-center', 'border', 'rounded', 'cursor-pointer',
                    'hover:bg-gray-100', 'svg-option');
                noneBtn.style.width = '90px';
                noneBtn.style.height = '90px';
                noneBtn.innerHTML = '<span style="font-size: 2.5rem; color: #ccc;">✕</span>';
                noneBtn.title = 'Aucun';
                noneBtn.setAttribute('data-part', 'none');

                noneBtn.addEventListener('click', () => {
                    document.getElementById(part).innerHTML = '';
                    container.querySelectorAll('.border-blue-500').forEach(s => s.classList.remove(
                        'border-blue-500'));
                    noneBtn.classList.add('border-blue-500');
                    selectedParts[part] = 'none';
                });
                noneBtn.addEventListener('mouseover', () => {
                    document.getElementById(part).innerHTML = '';
                });
                noneBtn.addEventListener('mouseout', () => {
                    restoreSelectedPart(part);
                });
                container.appendChild(noneBtn);
            }

            elements.forEach(element => {
                const parser = new DOMParser();
                const svgDoc = parser.parseFromString(element.svg_content, 'image/svg+xml');
                const svg = svgDoc.documentElement;

                svg.setAttribute('width', '90');
                svg.setAttribute('height', '90');
                svg.style.minWidth = '90px';
                svg.style.minHeight = '90px';
                svg.classList.add('cursor-pointer', 'border', 'rounded', 'p-1', 'hover:bg-gray-100',
                    'svg-option');
                svg.setAttribute('data-part', element.element_name);

                svg.addEventListener('click', () => {
                    setPart(part, element.element_name);
                    container.querySelectorAll('.border-blue-500').forEach(s => s.classList.remove(
                        'border-blue-500'));
                    svg.classList.add('border-blue-500');
                    selectedParts[part] = element.element_name;
                });

                svg.addEventListener('mouseover', () => {
                    setPart(part, element.element_name);
                });

                svg.addEventListener('mouseout', () => {
                    restoreSelectedPart(part);
                });

                container.appendChild(svg);
            });

            if (selectedParts[part]) {
                const selectedElement = container.querySelector(`[data-part="${selectedParts[part]}"]`);
                if (selectedElement) {
                    selectedElement.classList.add('border-blue-500');
                }
            }
        }

        function restoreSelectedPart(part) {
            const elementName = selectedParts[part] || '';
            if (elementName && elementName !== 'none') {
                setPart(part, elementName);
            } else {
                document.getElementById(part).innerHTML = '';
            }
        }

        function setPart(part, name) {
            if (name === 'none') {
                document.getElementById(part).innerHTML = '';
                return;
            }
            const element = svgElements.find(e => e.element_type === part && e.element_name === name);
            if (!element) return;
            const g = document.getElementById(part);
            const parser = new DOMParser();
            const doc = parser.parseFromString(element.svg_content, 'image/svg+xml');
            const svgContent = doc.documentElement;
            const defs = svgContent.querySelector('defs');
            if (defs) defs.remove();
            g.innerHTML = svgContent.innerHTML;

            // Ajuster la taille du background sans affecter l'avatar
            if (part === 'background') {
                const backgroundG = document.getElementById('background');
                if (backgroundG) {
                    backgroundG.style.transform = 'scale(1)';
                    backgroundG.style.transformOrigin = 'center';
                    backgroundG.style.position = 'absolute';
                    backgroundG.style.top = '0';
                    backgroundG.style.left = '0';
                    backgroundG.style.width = '100%';
                    backgroundG.style.height = '100%';
                }
            }
        }

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

        async function sauvegarder() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                alert('Vous devez être connecté pour sauvegarder.');
                return;
            }

            const svg = document.getElementById('avatar-canvas');
            const serializer = new XMLSerializer();
            let avatarSvg = serializer.serializeToString(svg);
            if (!avatarSvg.match(/^<svg[^>]+xmlns="http\:\/\/www\.w3\.org\/2000\/svg"/)) {
                avatarSvg = avatarSvg.replace(/^<svg/, '<svg xmlns="http://www.w3.org/2000/svg"');
            }
            if (!avatarSvg.match(/^<svg[^>]+"http\:\/\/www\.w3\.org\/1999\/xlink"/)) {
                avatarSvg = avatarSvg.replace(/^<svg/, '<svg xmlns:xlink="http://www.w3.org/1999/xlink"');
            }
            const avatarName = document.getElementById('avatar-name').innerText || 'Avatar_default';

            try {
                const response = await fetch('http://localhost:8000/api/avatar_complet', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        avatar_svg: avatarSvg,
                        avatar_name: avatarName,
                    }),
                });

                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(`${response.status} - ${err.message}`);
                }

                const data = await response.json();
                alert('Sauvegarde réussie !');
            } catch (error) {
                alert('Erreur lors de la sauvegarde : ' + error.message);
            }
        }

        document.addEventListener('DOMContentLoaded', async () => {
            await loadSvgElements();

            // Initialiser les sélecteurs de parties
            const partSelectors = document.querySelectorAll('.part-selector');
            partSelectors.forEach(button => {
                button.addEventListener('click', () => {
                    partSelectors.forEach(btn => btn.classList.remove('bg-00AFF5',
                        'text-white'));
                    button.classList.add('bg-00AFF5', 'text-white');
                    currentPart = button.getAttribute('data-part');
                    renderSvgPreviews(currentPart);
                    document.getElementById('color-picker').style.display = colorSelectors[
                        currentPart] ? 'inline-block' : 'none';
                });
            });

            // Afficher les options du visage par défaut
            document.querySelector('.part-selector[data-part="visage"]').classList.add('bg-00AFF5',
                'text-white');
            renderSvgPreviews('visage');

            // Gestion du color picker
            const colorPicker = document.getElementById('color-picker');
            const colorValue = document.getElementById('color-value');
            colorPicker.addEventListener('input', (e) => {
                const color = e.target.value;
                changePartColor(currentPart, color);
                colorValue.textContent = color;
            });

            // Définir les éléments par défaut sans background par défaut

            selectedParts['haut'] = 'haut';
            selectedParts['visage'] = 'visage';
            selectedParts['nez'] = 'nez_1';
            selectedParts['bouche'] = 'bouche_1';
            selectedParts['yeux'] = 'yeux_1';
            selectedParts['sourcils'] = 'sourcils_1';
            setPart('haut', 'haut');
            setPart('visage', 'visage');
            setPart('nez', 'nez_1');
            setPart('bouche', 'bouche_1');
            setPart('yeux', 'yeux_1');
            setPart('sourcils', 'sourcils_1');

        });
    </script>
@endsection
