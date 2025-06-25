@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Ma Bibliothèque d'Avatars</h1>
        <div id="avatars-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Les avatars seront insérés ici par JavaScript -->
        </div>
    </div>

    <script>
        async function loadAvatars() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                alert('Vous devez être connecté pour voir votre bibliothèque.');
                window.location.href = '/login';
                return;
            }

            try {
                const response = await fetch('http://localhost:8000/api/bibliotheque', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || `Erreur ${response.status}`);
                }

                const avatars = await response.json();
                const container = document.getElementById('avatars-container');

                if (avatars.length === 0) {
                    container.innerHTML = '<p class="text-center text-gray-500">Aucun avatar trouvé.</p>';
                    return;
                }

                container.innerHTML = avatars.map(avatar => `
                    <div class="avatar-preview bg-indigo-800 rounded-lg p-4 flex flex-col items-center shadow-lg">
                        <div class="w-32 h-32 mb-2">${avatar.avatar_svg}</div>
                        <p class="text-white font-semibold">${avatar.avatar_name || 'Sans nom'}</p>
                        <p class="text-gray-300 text-sm">ID: ${avatar.avatar_id}</p>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Erreur lors du chargement des avatars:', error);
                alert('Erreur lors du chargement de la bibliothèque : ' + error.message);
            }
        }

        document.addEventListener('DOMContentLoaded', loadAvatars);
    </script>
@endsection