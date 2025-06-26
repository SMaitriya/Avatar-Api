@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Ma Bibliothèque d'Avatars</h1>
    
    <div id="avatars-container" class="mb-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        
    </div>
</div>


<div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 space-y-2 sm:space-y-0 sm:space-x-2 sm:flex">
    <button onclick="handleView()" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-8 rounded-full border-2 border-black ml-4 flex items-center gap-2">
  Voir <img src="{{ asset('images/visualiser.svg') }}" alt="Voir" class="w-5 h-5">
</button>

    <button onclick="handleDownload()" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-full border-2 border-black ml-4 flex items-center gap-2">
        Télécharger<img src="{{ asset('images/telecharger.svg') }}" alt="Voir" class="w-8 h-8"></button>
    <button onclick="handleDelete()" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded-full border-2 border-black ml-4 flex items-center gap-2">
        
        Supprimer<img src="{{ asset('images/supprimer.svg') }}" alt="Voir" class="w-7 h-7"></button>
</div>


<!-- Modal simple -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm">
        <div class="text-center">
            <div id="modal-avatar" class="w-64 h-64 mx-auto mb-4 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
                <div class="w-full h-full flex items-center justify-center">
                </div>
            </div>
            <p id="modal-name" class="font-bold"></p>
            <button onclick="closeModal()" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded">Fermer</button>
        </div>
    </div>
</div>

<script>
let avatars = [];
let selectedAvatarId = null;

async function loadAvatars() {
    const token = localStorage.getItem('api_token');
    if (!token) {
        alert('Connectez-vous d\'abord');
        window.location.href = '/login';
        return;
    }

    try {
        const response = await fetch('http://localhost:8000/api/bibliotheque', {
            headers: { 'Authorization': `Bearer ${token}` }
        });
        
        avatars = await response.json();
        displayAvatars();
    } catch (error) {
        alert('Erreur de chargement');
    }
}

function displayAvatars() {
    const container = document.getElementById('avatars-container');
    
    if (avatars.length === 0) {
        container.innerHTML = '<p class="text-center text-gray-500 col-span-full">Aucun avatar</p>';
        return;
    }

    container.innerHTML = avatars.map(avatar => `
        <div onclick="selectAvatar('${avatar.avatar_id}', this)" 
             class="bg-white rounded-lg shadow-md p-4 text-center cursor-pointer transition ring-offset-2">
            <div class="w-32 h-32 mx-auto mb-3 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                <div class="w-full h-full flex items-center justify-center">
                    ${avatar.avatar_svg}
                </div>
            </div>
            <p class="font-semibold mb-3">${avatar.avatar_name || 'Sans nom'}</p>
        </div>
    `).join('');
}

function selectAvatar(id, element) {
    selectedAvatarId = id;
    
    // Retire l'effet sur tous
    const all = document.querySelectorAll('#avatars-container > div');
    all.forEach(div => div.classList.remove('ring-2', 'ring-blue-500'));
    
    // Ajoute l'effet sur le sélectionné
    element.classList.add('ring-2', 'ring-blue-500');
}

function handleView() {
    if (!selectedAvatarId) return alert('Sélectionnez un avatar');
    viewAvatar(selectedAvatarId);
}

function handleDownload() {
    if (!selectedAvatarId) return alert('Sélectionnez un avatar');
    downloadAvatar(selectedAvatarId);
}

function handleDelete() {
    if (!selectedAvatarId) return alert('Sélectionnez un avatar');
    deleteAvatar(selectedAvatarId);
}

function viewAvatar(id) {
    const avatar = avatars.find(a => a.avatar_id === id);
    const modalContainer = document.getElementById('modal-avatar');
    modalContainer.querySelector('div').innerHTML = avatar.avatar_svg;
    document.getElementById('modal-name').textContent = avatar.avatar_name || 'Sans nom';
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.getElementById('modal').classList.remove('flex');
}

function downloadAvatar(id) {
    const avatar = avatars.find(a => a.avatar_id === id);
    const blob = new Blob([avatar.avatar_svg], { type: 'image/svg+xml' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = `${avatar.avatar_name || 'avatar'}.svg`;
    link.click();
}

async function deleteAvatar(id) {
    const avatar = avatars.find(a => a.avatar_id === id);
    if (!confirm(`Supprimer "${avatar.avatar_name}" ?`)) return;
    
    const token = localStorage.getItem('api_token');
    try {
        const response = await fetch(`http://localhost:8000/api/avatars/${id}`, {
            method: 'DELETE',
            headers: { 
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Erreur inconnue');
        }

        alert('Avatar supprimé avec succès');
        loadAvatars();
        selectedAvatarId = null;
    } catch (error) {
        alert('Erreur de suppression : ' + error.message);
    }
}

document.addEventListener('DOMContentLoaded', loadAvatars);
</script>
@endsection
