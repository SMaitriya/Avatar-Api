<nav class="bg-white shadow-md p-4 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <img src="" alt="Logo" class="h-10">
            <span class="text-xl font-semibold">Avatar API</span>
        </div>
        <div class="flex space-x-6 items-center" id="nav-auth">
            <!-- Liens dynamiques JS ici -->
        </div>
    </div>
</nav>

<script>
    async function fetchUserPseudo(token) {
        try {
            const res = await fetch('/api/user', {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            if (res.ok) {
                const data = await res.json();
                return data.pseudo || 'Profil';
            }
        } catch (e) {}
        return 'Profil';
    }

    async function updateNavbarAuth() {
        const nav = document.getElementById('nav-auth');
        const token = localStorage.getItem('api_token');
        if (token) {
            const pseudo = await fetchUserPseudo(token);
            nav.innerHTML = `
                <a href="/" class="text-gray-600 hover:text-blue-500">Accueil</a>
                <a href="/bibliotheque" class="text-gray-600 hover:text-blue-500">Bibliothèque</a>
                <a href="/profil" class="text-gray-600 hover:text-blue-500">${await pseudo}</a>
                <a href="#" class="text-gray-600 hover:text-blue-500" onclick="logoutApi();return false;">Déconnexion</a>
            `;
        } else {
            nav.innerHTML = `
                <a href="/" class="text-gray-600 hover:text-blue-500">Accueil</a>
                <a href="/login" class="text-gray-600 hover:text-blue-500">Connexion</a>
                <a href="/register" class="text-gray-600 hover:text-blue-500 font-bold underline">Inscription</a>
            `;
        }
    }

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

    updateNavbarAuth();
</script>
