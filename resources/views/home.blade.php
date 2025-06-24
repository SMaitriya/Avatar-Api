@extends('layouts.app')

@section('content')
    <div class="container" style="max-width:900px;margin:auto;">

        <h2 class="text-center mb-4">Créer mon avatar</h2>

        <div style="display:flex;justify-content:center;">
            <!-- Canvas SVG centré -->
            <div
                style="background:#f5f5f5;border-radius:24px;padding:32px;box-shadow:0 4px 12px rgba(0,0,0,0.07);display:inline-block;">
                <svg id="avatar-canvas" width="280" height="280" viewBox="0 0 300 300"
                    style="background:#fff;display:block;margin:auto;">
                    <g id="background"></g>
                    <g id="visage"></g>
                    <g id="nez"></g>
                    <g id="bouche"></g>
                    <g id="yeux"></g>
                    <g id="sourcils"></g>
                    <g id="cheveux"></g>
                    <g id="barbe"></g>
                    <g id="lunettes"></g>
                    <g id="accessoire"></g>
                    <g id="haut"></g>
                </svg>
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
        // Liste des types
        const elementTypes = [
            'background', 'visage', 'nez', 'bouche', 'yeux', 'sourcils', 'cheveux', 'barbe', 'lunettes', 'accessoire',
            'haut'
        ];
        let svgElements = [];

        // Charger SVG depuis localStorage ou API
        async function loadSvgElements() {
            const cached = localStorage.getItem('svgElementsCache');
            if (cached) {
                svgElements = JSON.parse(cached);
                return;
            }
            const res = await fetch('/api/svg-elements');
            svgElements = await res.json();
            localStorage.setItem('svgElementsCache', JSON.stringify(svgElements));
        }

        // Générer galerie claire et responsive
        function renderChoices() {
            const choicesArea = document.getElementById('choices-area');
            choicesArea.innerHTML = '';
            elementTypes.forEach(type => {
                const group = svgElements.filter(e => e.element_type === type);
                if (group.length === 0) return;
                // Un bloc par type avec titre
                const section = document.createElement('section');
                section.style.background = "#fff";
                section.style.borderRadius = "16px";
                section.style.boxShadow = "0 1px 8px rgba(0,0,0,0.06)";
                section.style.padding = "12px 18px 12px 18px";
                section.innerHTML = `<h4 style="text-transform:capitalize;margin-bottom:8px;">${type}</h4>`;
                const partDiv = document.createElement('div');
                partDiv.className = 'avatar-parts';
                partDiv.style.display = "flex";
                partDiv.style.flexWrap = "wrap";
                partDiv.style.gap = "12px";
                group.forEach(item => {
                    const choice = document.createElement('div');
                    choice.className = 'avatar-choice';
                    choice.setAttribute('data-type', item.element_type);
                    choice.setAttribute('data-name', item.element_name);
                    choice.setAttribute('data-svg', item.svg_content);
                    choice.style.cursor = "pointer";
                    choice.style.transition = "transform .13s";
                    choice.style.padding = "3px";
                    choice.style.borderRadius = "9px";
                    choice.style.boxShadow = "0 1px 3px rgba(0,0,0,0.05)";
                    choice.style.background = "#f9f9f9";
                    choice.style.border = "2px solid transparent";
                    choice.style.display = "flex";
                    choice.style.alignItems = "center";
                    choice.style.justifyContent = "center";
                    choice.onmouseover = () => choice.style.border = "2px solid #4A90E2";
                    choice.onmouseout = () => choice.style.border = "2px solid transparent";
                    choice.onclick = () => setPart(item.element_type, item.element_name);
                    // Petit SVG de prévisualisation
                    let previewSvg = item.svg_content.replace('<svg ', `<svg width="48" height="48" `);
                    choice.innerHTML = previewSvg;
                    partDiv.appendChild(choice);
                });
                section.appendChild(partDiv);
                choicesArea.appendChild(section);
            });
        }

        // Fonction pour mettre à jour l'avatar complet
        function setPart(part, name) {
            const element = svgElements.find(e => e.element_type === part && e.element_name === name);
            if (!element) return;
            document.getElementById(part).innerHTML = element.svg_content;
            if (document.getElementById('color-target').value === part) {
                recolorElement(part);
            }
        }

        // Colorisation dynamique
        function recolorElement(part) {
            const color = document.getElementById('color-picker').value;
            document.querySelectorAll(`#${part} [fill], #${part} .colorizable`).forEach(el => {
                el.setAttribute('fill', color);
            });
        }
        document.getElementById('color-picker').addEventListener('input', function() {
            document.getElementById('color-value').textContent = this.value;
            recolorElement(document.getElementById('color-target').value);
        });
        document.getElementById('color-target').addEventListener('change', function() {
            recolorElement(this.value);
        });

        // Téléchargement SVG
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

        // Initialisation automatique
        document.addEventListener('DOMContentLoaded', async () => {
            await loadSvgElements();
            renderChoices();
            elementTypes.forEach(type => {
                const first = svgElements.find(e => e.element_type === type);
                if (first) setPart(type, first.element_name);
            });
        });
    </script>
@endsection
