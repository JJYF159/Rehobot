document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btnLogin = document.getElementById('btnLogin');
    const loading = document.getElementById('loading');
    const alertContainer = document.getElementById('alertContainer');
    
    // Mostrar loading
    btnLogin.disabled = true;
    loading.style.display = 'block';
    alertContainer.innerHTML = '';
    
    // Obtener datos del formulario
    const formData = new FormData(this);
    
    try {
        const response = await fetch('../php/login_cookie.php', {
            method: 'POST',
            body: formData,
            credentials: 'include' // Importante para cookies
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Login exitoso
            alertContainer.innerHTML = `
                <div class="alert alert-success">
                    ✅ Login exitoso. Redirigiendo...
                </div>
            `;
            
            console.log('✅ Login exitoso, redirigiendo al admin...');
            
            setTimeout(() => {
                window.location.href = 'index.html?from=login';
            }, 1500);
        } else {
            // Error en login
            alertContainer.innerHTML = `
                <div class="alert alert-error">
                    ❌ ${result.message}
                </div>
            `;
        }
    } catch (error) {
        alertContainer.innerHTML = `
            <div class="alert alert-error">
                ❌ Error de conexión. Intente nuevamente.
            </div>
        `;
    } finally {
        btnLogin.disabled = false;
        loading.style.display = 'none';
    }
});

// Verificar si ya está logueado
window.addEventListener('load', async function() {
    try {
        const response = await fetch('../php/verificar_sesion.php');
        const result = await response.json();
        
        if (result.loggedIn) {
            console.log('✅ Ya hay sesión activa, redirigiendo al admin...');
            window.location.href = 'index.html';
        }
    } catch (error) {
        console.log('ℹ️ No hay sesión activa');
    }
});
