<?php
// Configuración de sesiones mejorada para desarrollo y producción
if (!defined('SESSION_CONFIGURED')) {
    define('SESSION_CONFIGURED', true);
    
    // Solo configurar si la sesión no ha iniciado
    if (session_status() === PHP_SESSION_NONE) {
        
        // Detectar si es desarrollo local o servidor
        $isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']) 
                   || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false;
        
        // Configuración base de sesiones
        ini_set('session.cookie_lifetime', 28800); // 8 horas
        ini_set('session.gc_maxlifetime', 28800);
        ini_set('session.cookie_httponly', '1');
        ini_set('session.use_strict_mode', '1');
        ini_set('session.cookie_samesite', 'Lax');
        
        if ($isLocal) {
            // Configuración para desarrollo local
            ini_set('session.cookie_secure', '0'); // HTTP permitido
            ini_set('session.cookie_domain', ''); // Sin dominio específico
        } else {
            // Configuración para producción
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? '1' : '0');
            ini_set('session.cookie_domain', ''); // Dejar que PHP lo maneje automáticamente
        }
        
        ini_set('session.cookie_path', '/');
        
        // Usar directorio de sesiones más confiable
        $sessionDir = sys_get_temp_dir() . '/rehobot_sessions';
        if (!is_dir($sessionDir)) {
            @mkdir($sessionDir, 0755, true);
        }
        
        if (is_dir($sessionDir) && is_writable($sessionDir)) {
            session_save_path($sessionDir);
        } else {
            // Fallback al directorio temporal del sistema
            session_save_path(sys_get_temp_dir());
        }
        
        // Nombre de sesión personalizado
        session_name('REHOBOT_ADMIN_SESSION');
        
        // Forzar habilitación de sesiones
        ini_set('session.auto_start', '0');
        ini_set('session.use_cookies', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_trans_sid', '0');
        
        // Intentar múltiples métodos para iniciar sesión
        $sessionStarted = false;
        
        // Método 1: Intentar con configuración actual
        $sessionStarted = @session_start();
        
        if (!$sessionStarted) {
            error_log("INTENTO 1 FALLÓ: Probando método alternativo");
            
            // Método 2: Configuración más simple
            session_save_path('/tmp');
            ini_set('session.save_handler', 'files');
            $sessionStarted = @session_start();
        }
        
        if (!$sessionStarted) {
            error_log("INTENTO 2 FALLÓ: Probando último método");
            
            // Método 3: Forzar configuración básica
            ini_set('session.save_path', '/tmp');
            ini_set('session.name', 'PHPSESSID');
            $sessionStarted = @session_start();
        }
        
        if (!$sessionStarted) {
            error_log("ERROR CRÍTICO: No se pudo iniciar ninguna sesión");
            // Crear un sistema de sesiones personalizado usando cookies
            define('CUSTOM_SESSION_MODE', true);
        } else {
            error_log("ÉXITO: Sesión iniciada con ID: " . session_id());
        }
        
        // Regenerar ID de sesión ocasionalmente para seguridad
        if (!isset($_SESSION['regenerated']) || (time() - $_SESSION['regenerated']) > 1800) {
            session_regenerate_id(true);
            $_SESSION['regenerated'] = time();
        }
        
        // Log de debug solo en desarrollo
        if ($isLocal && function_exists('error_log')) {
            error_log("DEBUG - Session iniciada - ID: " . session_id());
            error_log("DEBUG - Save path: " . session_save_path());
            error_log("DEBUG - Cookie params: " . json_encode(session_get_cookie_params()));
        }
    }
}

// Función simple para iniciar sesión
function iniciar_sesion_segura() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Función para verificar si la sesión es válida
function verificar_sesion_valida() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verificar si hay datos de sesión de admin
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

// Función para obtener información del usuario de sesión
function obtener_usuario_sesion() {
    if (!verificar_sesion_valida()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['admin_user_id'] ?? null,
        'usuario' => $_SESSION['admin_user'] ?? 'admin',
        'nombre_completo' => $_SESSION['admin_nombre'] ?? 'Administrador',
        'rol' => $_SESSION['admin_rol'] ?? 'admin'
    ];
}
?>
