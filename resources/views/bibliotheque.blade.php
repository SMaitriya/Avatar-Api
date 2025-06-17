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
       
        <div class="bg-yellow-100 min-h-screen p-8">
    <!-- Titre -->
    <h1 class="text-3xl font-bold mb-8 text-center">Bibliothèque</h1>

    <!-- Grille des avatars -->
    <div class="grid grid-cols-5 gap-8 justify-items-center">
        <!-- Avatar card (exemple à répéter) -->
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-rose-400 rounded-md flex items-center justify-center">
                <!-- Cercle de tête -->
                <div class="w-10 h-10 bg-yellow-300 rounded-full"></div>
            </div>
            <span class="mt-2 bg-yellow-300 px-2 py-1 rounded text-sm">Avatar_1</span>
        </div>

        <!-- Répéter cette structure pour chaque avatar -->
        <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-rose-400 rounded-md flex items-center justify-center">
                <div class="w-10 h-10 bg-yellow-300 rounded-full"></div>
            </div>
            <span class="mt-2 bg-yellow-300 px-2 py-1 rounded text-sm">Avatar_2</span>
        </div>

        <!-- etc... -->
    </div>

    <!-- Boutons d'action -->
    <div class="flex justify-center space-x-8 mt-12">
        <button class="bg-purple-800 text-white py-2 px-6 rounded-full flex items-center space-x-2">
            <span>Visualiser</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 01-6 0m6 0a3 3 0 00-6 0m9 4a9 9 0 01-18 0M15 12a3 3 0 00-6 0m6 0a3 3 0 01-6 0"/>
            </svg>
        </button>

        <button class="bg-pink-500 text-white py-2 px-6 rounded-full flex items-center space-x-2">
            <span>Télécharger</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v8m0 0l4-4m-4 4l-4-4" />
            </svg>
        </button>

        <button class="bg-red-600 text-white py-2 px-6 rounded-full flex items-center space-x-2">
            <span>Supprimer</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>


       
    </body>
</html>