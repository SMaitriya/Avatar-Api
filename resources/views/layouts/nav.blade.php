
<nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16"> <!-- plus grand -->
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
        nav.innerHTML = `
            <a href="/" class="text-gray-600 hover:text-blue-500">Accueil</a>
            <a href="/login" class="text-gray-600 hover:text-blue-500">Connexion</a>
            <a href="/register" class="text-gray-600 hover:text-blue-500 font-bold underline">Inscription</a>
        `;
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
