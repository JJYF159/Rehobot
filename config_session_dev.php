<?php
// Configuración simple para desarrollo local
ini_set('session.cookie_domain', '');
ini_set('session.cookie_path', '/');
ini_set('session.cookie_secure', '0');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', '28800');
ini_set('session.cookie_lifetime', '28800');

// Para desarrollo local, usar el directorio temporal del sistema
session_save_path(sys_get_temp_dir());

echo "✅ Configuración de sesiones aplicada para desarrollo local\n";
echo "📂 Directorio de sesiones: " . session_save_path() . "\n";
echo "🍪 Cookie lifetime: " . ini_get('session.cookie_lifetime') . " segundos\n";
echo "⏰ GC maxlifetime: " . ini_get('session.gc_maxlifetime') . " segundos\n";
?>
