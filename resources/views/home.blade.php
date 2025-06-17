<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
       @include('layouts.nav')
       
        <div class="flex flex-col items-center justify-center min-h-screen bg-yellow-100 p-6">

    <!-- Section principale avatar -->
    <div class="flex items-center justify-center mb-8">
        <!-- Bouton Sauvegarder -->
        <button class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-full border-2 border-black mr-4">
            Sauvegarder 
        </button>

        <!-- Zone d'affichage de l'avatar -->
        <div class="bg-indigo-800 rounded-lg p-6">
            <!-- Avatar lui-même -->
            <div class="relative w-64 h-64 bg-purple-900 rounded-lg flex items-center justify-center">
                <!-- Fond (couleur de fond actuelle) -->
                <div class="absolute inset-0 rounded-lg" style="background-color: #1300BA;"></div>

                <!-- Éléments de l'avatar (exemple simplifié) -->
                <div class="relative">
                    <!-- Background stars -->
                    <div class="absolute top-2 right-2 text-yellow-400 text-xl">⭐ ⭐ ⭐</div>

                    <!-- Tête -->
                    <div class="w-24 h-24 bg-pink-200 rounded-full mx-auto"></div>

                    <!-- Corps -->
                    <div class="mt-4 mx-auto w-24 h-32 bg-green-700" style="clip-path: polygon(50% 0%, 100% 100%, 0% 100%);"></div>
                </div>
            </div>

            <!-- Nom de l'avatar -->
            <div class="mt-4 text-center bg-yellow-300 py-1 px-3 rounded-md font-semibold text-gray-800">
                Avatar_1
            </div>
        </div>

        <!-- Bouton Télécharger -->
        <button class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-full border-2 border-black ml-4">
            Télécharger 
        </button>
    </div>

    <!-- Barre de modifications (simplifiée) -->
    <div class="flex flex-wrap justify-center space-x-4 space-y-2">
        <!-- Exemple d'éléments de personnalisation -->
        <div class="w-12 h-12 bg-pink-200 border rounded-lg"></div>
        <div class="w-12 h-12 bg-white border rounded-lg flex items-center justify-center text-xl">👁️</div>
        <div class="w-12 h-12 bg-white border rounded-lg flex items-center justify-center text-xl">👄</div>
        <div class="w-12 h-12 bg-white border rounded-lg"></div>
        <div class="w-12 h-12 bg-green-700 border rounded-lg"></div>
        <div class="w-12 h-12 bg-indigo-900 border rounded-lg"></div>
    </div>

    <!-- Zone sliders et color picker -->
   <div class="flex items-center justify-center space-x-8 mt-6 w-full">

    <!-- Sélection du type -->
    <div class="flex flex-wrap justify-center gap-2">
        <button class="w-12 h-12 border rounded-lg flex items-center justify-center bg-white shadow hover:bg-gray-200">
            😃
        </button>
        <button class="w-12 h-12 border rounded-lg flex items-center justify-center bg-white shadow hover:bg-gray-200">
            😮
        </button>
        <button class="w-12 h-12 border rounded-lg flex items-center justify-center bg-white shadow hover:bg-gray-200">
            😐
        </button>
        <button class="w-12 h-12 border rounded-lg flex items-center justify-center bg-white shadow hover:bg-gray-200">
            😁
        </button>
    </div>

    <!-- Slider de taille -->
    <div class="flex items-center space-x-2">
        <label class="font-semibold text-gray-700">Taille:</label>
        <input type="range" min="10" max="200" value="100" class="w-32">
    </div>

    <!-- Sélection de couleur -->
    <div class="flex items-center space-x-2">
        <label class="font-semibold text-gray-700">Couleur:</label>
        <input type="text" value="#1300BA" class="border rounded-lg p-1 w-20 text-center">
        <div class="w-8 h-8 rounded-lg border shadow" style="background-color: #1300BA;"></div>
    </div>

</div>


</div>


       
    </body>
</html>