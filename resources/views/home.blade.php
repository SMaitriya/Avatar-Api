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
                    <!-- Zone SVG pour l'avatar -->
                    <svg id="avatar-canvas" width="200" height="200" viewBox="0 0 200 200">
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
            <!-- Barre de modifications (sous-menus de sélection) -->
            <div class="flex flex-col items-center gap-6">
                <!-- Choix du background -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Arrière-plan :</span>
                    <select onchange="setPart('background', this.value)" class="border rounded px-2 py-1">
                        <option value="background_1">Arrière-plan 1</option>
                        <option value="background_2">Arrière-plan 2</option>
                        <option value="background_3">Arrière-plan 3</option>
                    </select>
                </div>
                <!-- Choix du visage -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Visage :</span>
                    <select onchange="setPart('visage', this.value)" class="border rounded px-2 py-1">
                        <option value="visage">Visage</option>
                    </select>
                </div>
                <!-- Choix du nez -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Nez :</span>
                    <select onchange="setPart('nez', this.value)" class="border rounded px-2 py-1">
                        <option value="nez_1">Nez 1</option>
                        <option value="nez_2">Nez 2</option>
                        <option value="nez_3">Nez 3</option>
                    </select>
                </div>
                <!-- Choix de la bouche -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Bouche :</span>
                    <select onchange="setPart('bouche', this.value)" class="border rounded px-2 py-1">
                        <option value="bouche_1">Bouche 1</option>
                        <option value="bouche_2">Bouche 2</option>
                        <option value="bouche_3">Bouche 3</option>
                    </select>
                </div>
                <!-- Choix des yeux -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Yeux :</span>
                    <select onchange="setPart('yeux', this.value)" class="border rounded px-2 py-1">
                        <option value="yeux_1">Yeux 1</option>
                        <option value="yeux_2">Yeux 2</option>
                        <option value="yeux_3">Yeux 3</option>
                    </select>
                </div>
                <!-- Choix des sourcils -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Sourcils :</span>
                    <select onchange="setPart('sourcils', this.value)" class="border rounded px-2 py-1">
                        <option value="sourcils_1">Sourcils 1</option>
                        <option value="sourcils_2">Sourcils 2</option>
                        <option value="sourcils_3">Sourcils 3</option>
                    </select>
                </div>
                <!-- Choix des cheveux -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Cheveux :</span>
                    <select onchange="setPart('cheveux', this.value)" class="border rounded px-2 py-1">
                        <option value="cheveux_1">Cheveux 1</option>
                        <option value="cheveux_2">Cheveux 2</option>
                    </select>
                </div>
                <!-- Choix de la barbe -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Barbe :</span>
                    <select onchange="setPart('barbe', this.value)" class="border rounded px-2 py-1">
                        <option value="barbe_1">Barbe 1</option>
                        <option value="barbe_2">Barbe 2</option>
                    </select>
                </div>
                <!-- Choix des lunettes -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Lunettes :</span>
                    <select onchange="setPart('lunettes', this.value)" class="border rounded px-2 py-1">
                        <option value="lunettes_1">Lunettes 1</option>
                        <option value="lunettes_2">Lunettes 2</option>
                    </select>
                </div>
                <!-- Choix des accessoires -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Accessoire :</span>
                    <select onchange="setPart('accessoire', this.value)" class="border rounded px-2 py-1">
                        <option value="collier">Collier</option>
                        <option value="potara">Potara</option>
                    </select>
                </div>
                <!-- Choix du haut -->
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Haut :</span>
                    <select onchange="setPart('haut', this.value)" class="border rounded px-2 py-1">
                        <option value="haut">Haut</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <script>
        let svgElements = []; // Tableau pour stocker les éléments SVG

        async function loadSvgElements() {
            const cached = localStorage.getItem('svgElementsCache');
            // Si les éléments SVG sont déjà en cache, on les utilise
            if (cached) {
                svgElements = JSON.parse(cached);
                return;
            }
            const res = await fetch('/api/svg-elements');
            svgElements = await res.json();
            localStorage.setItem('svgElementsCache', JSON.stringify(svgElements));
        }

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

        // --------------- CHARGEMENT DES SVGs
        function setPart(part, name) {
            const element = svgElements.find(e => e.element_type === part && e.element_name === name);
            if (!element) return;
            const g = document.getElementById(part);
            // Supprimer les <defs> existants pour éviter les conflits de styles
            const parser = new DOMParser();
            const doc = parser.parseFromString(element.svg_content, 'image/svg+xml');
            const svgContent = doc.documentElement;
            const defs = svgContent.querySelector('defs');
            if (defs) defs.remove(); // Retire les styles internes pour éviter les conflits
            g.innerHTML = svgContent.innerHTML;
            // Appliquer les styles dynamiquement en fonction de l'élément
            applyStyles(part, name);
        }

        // Appliquer les styles spécifiques à chaque partie
        function applyStyles(part, name) {
            const g = document.getElementById(part);
            switch (part) {
                case 'yeux':
                    if (name === 'yeux_1') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#fff'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#513e00'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('fill', '#28932a'));
                    } else if (name === 'yeux_2') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#bf8d00'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#fff'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('fill', '#513e00'));
                    } else if (name === 'yeux_3') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#274dc4'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#fff'));
                    }
                    break;
                case 'visage':
                    g.querySelectorAll('.cls-1, .cls-2').forEach(el => {
                        el.setAttribute('fill', '#606060');
                        el.setAttribute('opacity', '1');
                    });
                    g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('fill', '#e5cca3'));
                    g.querySelectorAll('.cls-2').forEach(el => {
                        el.setAttribute('stroke', '#000');
                        el.setAttribute('stroke-linecap', 'round');
                        el.setAttribute('stroke-linejoin', 'round');
                        el.setAttribute('stroke-width', '.5px');
                    });
                    break;
                case 'barbe':
                    if (name === 'barbe_1') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#bf8d00'));
                    } else if (name === 'barbe_2') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#fff'));
                    }
                    break;
                case 'bouche':
                    if (name === 'bouche_1') {
                        g.querySelectorAll('.cls-1, .cls-2').forEach(el => el.setAttribute('fill', '#606060'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('opacity', '.5'));
                    } else if (name === 'bouche_2') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#ad6d7b'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#a16057'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('fill', '#ae5969'));
                    } else if (name === 'bouche_3') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#606060'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#fff'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('opacity', '.4'));
                        g.querySelectorAll('.cls-4').forEach(el => el.setAttribute('opacity', '.3'));
                    }
                    break;
                case 'cheveux':
                    if (name === 'cheveux_1') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#2b2b2b'));
                        g.querySelectorAll('.cls-2').forEach(el => {
                            el.setAttribute('fill', '#606060');
                            el.setAttribute('opacity', '.5');
                        });
                    } else if (name === 'cheveux_2') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#10171f'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#2b364c'));
                        g.querySelectorAll('.cls-3, .cls-4').forEach(el => el.setAttribute('fill', '#435664'));
                        g.querySelectorAll('.cls-5').forEach(el => el.setAttribute('fill', '#161b26'));
                        g.querySelectorAll('.cls-6').forEach(el => el.setAttribute('fill', '#8c8c8c'));
                    }
                    break;
                case 'collier':
                    g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#711'));
                    g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#fff'));
                    g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('opacity', '.5'));
                    break;
                case 'haut':
                    g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#ffffa1'));
                    break;
                case 'lunettes':
                    if (name === 'lunettes_1') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#0068ff'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#0043ff'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('opacity', '.5'));
                    } else if (name === 'lunettes_2') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#ff00e7'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('opacity', '.5'));
                    }
                    break;
                case 'nez':
                    if (name === 'nez_1') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#606060'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('opacity', '.6'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('opacity', '.5'));
                    } else if (name === 'nez_2') {
                        g.querySelectorAll('.cls-1').forEach(el => {
                            el.setAttribute('fill', 'none');
                            el.setAttribute('stroke', '#2d2d2d');
                            el.setAttribute('stroke-miterlimit', '10');
                        });
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('fill', '#606060'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('opacity', '.6'));
                        g.querySelectorAll('.cls-4').forEach(el => el.setAttribute('opacity', '.5'));
                        g.querySelectorAll('.cls-5').forEach(el => el.setAttribute('fill', '#2d2d2d'));
                    } else if (name === 'nez_3') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#606060'));
                        g.querySelectorAll('.cls-2').forEach(el => el.setAttribute('opacity', '.6'));
                        g.querySelectorAll('.cls-3').forEach(el => el.setAttribute('opacity', '.5'));
                    }
                    break;
                case 'potara':
                    g.querySelectorAll('.cls-1').forEach(el => {
                        el.setAttribute('fill', '#fff');
                        el.setAttribute('opacity', '.5');
                    });
                    g.querySelectorAll('.cls-2').forEach(el => {
                        el.setAttribute('fill', '#fff');
                        el.setAttribute('opacity', '.2');
                    });
                    g.querySelectorAll('.cls-3').forEach(el => {
                        el.setAttribute('fill', '#fff');
                        el.setAttribute('opacity', '.95');
                    });
                    g.querySelectorAll('.cls-4, .cls-5').forEach(el => el.setAttribute('fill', '#39752f'));
                    g.querySelectorAll('.cls-5').forEach(el => {
                        el.setAttribute('stroke', '#39752f');
                        el.setAttribute('stroke-miterlimit', '10');
                        el.setAttribute('stroke-width', '2px');
                    });
                    g.querySelectorAll('.cls-6').forEach(el => el.setAttribute('fill', '#ab8f58'));
                    g.querySelectorAll('.cls-7').forEach(el => el.setAttribute('fill', '#6ed45f'));
                    g.querySelectorAll('.cls-8').forEach(el => el.setAttribute('fill', '#bda45a'));
                    break;
                case 'sourcils':
                    if (name === 'sourcils_1' || name === 'sourcils_2' || name === 'sourcils_3') {
                        g.querySelectorAll('.cls-1').forEach(el => el.setAttribute('fill', '#bf8d00'));
                    }
                    break;
            }
        }

        // Fonctions pour changer les parties de l'avatar
        document.addEventListener('DOMContentLoaded', async () => {
            await loadSvgElements(); // Attend que les données soient chargées
            // setPart('background', 'background_1');
            setPart('haut', 'haut');
            setPart('visage', 'visage');
            setPart('nez', 'nez_1');
            setPart('bouche', 'bouche_1');
            setPart('yeux', 'yeux_1');
            setPart('sourcils', 'sourcils_1');
            setPart('cheveux', 'cheveux_1');
            setPart('barbe', 'barbe_1');
            setPart('lunettes', 'lunettes_1');
            setPart('accessoire', 'collier');
        });
    </script>
@endsection
