@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Ma Bibliothèque d'Avatars</h1>
        <div id="avatars-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Les avatars seront insérés ici par JavaScript -->
        </div>
        <div id="no-avatars" class="hidden text-center text-gray-500 mt-6">Aucun avatar trouvé.</div>
    </div>
</div>

    <style>
        .avatar-preview {
            background: #4b5e9b;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
        }
        .avatar-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .avatar-preview svg {
            width: 100%;
            height: 100%;
            max-width: 128px;
            max-height: 128px;
            display: block;
            margin: 0 auto;
        }
        .avatar-preview p {
            margin: 0.25rem 0;
            text-align: center;
        }
        .avatar-preview .actions {
            margin-top: 0.5rem;
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        .avatar-preview button {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border: none;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .avatar-preview button.delete {
            background-color: #ef4444;
            color: white;
        }
        .avatar-preview button.delete:hover {
            background-color: #dc2626;
        }
        .avatar-preview button.edit {
            background-color: #3b82f6;
            color: white;
        }
        .avatar-preview button.edit:hover {
            background-color: #2563eb;
        }
    </style>

    <script>
        let avatarsData = [];

        async function loadAvatars() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                alert('Vous devez être connecté pour voir votre bibliothèque.');
                window.location.href = '/login';
                return;
            }
        });

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

                avatarsData = await response.json();
                const container = document.getElementById('avatars-container');
                const noAvatars = document.getElementById('no-avatars');

                if (avatarsData.length === 0) {
                    container.innerHTML = '';
                    noAvatars.classList.remove('hidden');
                    return;
                }

                noAvatars.classList.add('hidden');
                container.innerHTML = avatarsData.map(avatar => {
                    const parser = new DOMParser();
                    const svgDoc = parser.parseFromString(avatar.avatar_svg, 'image/svg+xml');
                    const svgElement = svgDoc.documentElement;
                    svgElement.setAttribute('viewBox', '0 0 200 200'); // Uniformiser la vue
                    return `
                        <div class="avatar-preview" data-id="${avatar.avatar_id}">
                            <div class="w-32 h-32 mb-2">${svgElement.outerHTML}</div>
                            <p class="text-white font-semibold">${avatar.avatar_name || 'Sans nom'}</p>
                            <p class="text-gray-300 text-sm">ID: ${avatar.avatar_id}</p>
                            <div class="actions">
                                <button class="edit" onclick="editAvatar('${avatar.avatar_id}')">Modifier</button>
                                <button class="delete" onclick="deleteAvatar('${avatar.avatar_id}')">Supprimer</button>
                            </div>
                        </div>
                    `;
                }).join('');
            } catch (error) {
                console.error('Erreur lors du chargement des avatars:', error);
                document.getElementById('avatars-container').innerHTML = '<p class="text-center text-red-500">Erreur lors du chargement. Veuillez réessayer.</p>';
            }
        }

        async function deleteAvatar(avatarId) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet avatar ?')) return;

            const token = localStorage.getItem('api_token');
            try {
                const response = await fetch(`http://localhost:8000/api/bibliotheque/${avatarId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    const err = await response.json();
                    throw new Error(err.message || `Erreur ${response.status}`);
                }

                alert('Avatar supprimé avec succès.');
                loadAvatars(); // Recharger la liste
            } catch (error) {
                alert('Erreur lors de la suppression : ' + error.message);
            }
        }

        function editAvatar(avatarId) {
            const avatar = avatarsData.find(a => a.avatar_id === avatarId);
            if (avatar) {
                // Rediriger vers une page de modification ou ouvrir un modal (à implémenter)
                alert(`Modification de l'avatar ${avatar.avatar_name} (ID: ${avatarId}). Implémentez la logique ici.`);
                // Exemple : window.location.href = `/edit-avatar/${avatarId}`;
            }
        }

        document.addEventListener('DOMContentLoaded', loadAvatars);
    </script>
@endsection
