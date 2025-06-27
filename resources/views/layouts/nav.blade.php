<nav class="bg-white shadow-md p-4 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16"> 
            <span class="text-4xl font-semibold tracking-wider" style="font-family: 'Bangers', cursive;">
                <span style="color:#FF9800;">Avatar</span>
                <span style="color:#00AFF5;">API</span>
            </span>
        </div>

        <div class="flex space-x-6 items-center" id="nav-auth">

        </div>
    </div>
</nav>

<script>

    // Recherche une clé API active correspondante en base
    async function fetchUserInfo(token) {
        try {
            const res = await fetch('/api/user', {
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });
            if (res.ok) {
                return await res.json();
            }
        } catch (e) {}
        return null;
    }

    // Met à jour la barre de navigation selon l'état de connexion
    async function updateNavbarAuth() {
        const nav = document.getElementById('nav-auth');
        const token = localStorage.getItem('api_token');
        if (token) {
            const userInfo = await fetchUserInfo(token);
            if (userInfo) {
                nav.innerHTML = `
                    <a href="/" class="text-gray-600 hover:text-blue-500">Accueil</a>
                    <a href="/bibliotheque" class="text-gray-600 hover:text-blue-500">Bibliothèque</a>
                    <a href="/profil" class="text-gray-600 hover:text-blue-500">${userInfo.pseudo}</a>
                    ${userInfo.is_admin ? `<a href="/admin/api-keys" class="text-gray-600 hover:text-purple-600 font-semibold">Admin/API Keys</a>` : ''}
                    <a href="#" class="text-gray-600 hover:text-blue-500" onclick="logoutApi();return false;">Déconnexion</a>
                `;
                return;
            }
        }
        // Affiche les liens pour les visiteurs non connectés
        nav.innerHTML = `
            <a href="/" class="text-gray-600 hover:text-blue-500">Accueil</a>
            <a href="/login" class="text-gray-600 hover:text-blue-500">Connexion</a>
            <a href="/register" class="text-gray-600 hover:text-blue-500">Inscription</a>
        `;
    }

    // Déconnecte l'utilisateur côté API et met à jour la navbar
    function logoutApi() {
        const token = localStorage.getItem('api_token');
        if (token) {
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                localStorage.removeItem('api_token');
                updateNavbarAuth();
                window.location.href = '/';
            });
        }
    }

    // Initialise la barre de navigation au chargement de la page
    updateNavbarAuth();
</script>
