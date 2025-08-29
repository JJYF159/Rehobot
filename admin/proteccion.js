// Protección mejorada de acceso al panel de administración
(function() {
    'use strict';
    
    console.log('🛡️ Iniciando verificación de acceso...');
    
    // No ocultar el contenido inmediatamente, solo verificar
    let verificacionCompleta = false;
    
    // Verificar sesión al cargar
    document.addEventListener('DOMContentLoaded', function() {
        verificarAccesoInmediato();
    });
    
    async function verificarAccesoInmediato() {
        try {
            console.log('🔍 Verificando sesión...');
            
            const response = await fetch('../php/verificar_cookie.php', {
                method: 'GET',
                credentials: 'include', // Importante para cookies
                cache: 'no-cache'
            });
            
            if (!response.ok) {
                console.log('❌ Error de conexión al verificar sesión');
                throw new Error('Error de conexión');
            }
            
            const result = await response.json();
            
            if (!result.loggedIn) {
                console.log('🚫 No hay sesión válida, redirigiendo al login...');
                setTimeout(() => {
                    window.location.replace('login.html');
                }, 100);
                return;
            }
            
            console.log('✅ Sesión válida para:', result.user.nombre);
            verificacionCompleta = true;
            window.adminAuthorized = true;
            
        } catch (error) {
            console.error('🚫 Error verificando acceso:', error);
            setTimeout(() => {
                window.location.replace('login.html');
            }, 1000);
        }
    }
    
    // Protección contra acceso directo mediante URL
    if (window.location.search.includes('direct=true')) {
        console.log('⚠️ Intento de acceso directo detectado');
        verificarAccesoInmediato();
    }
    
})();
