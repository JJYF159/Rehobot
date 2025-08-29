<?php
require_once 'session_config.php';
require_once 'auth.php';

// Iniciar sesión con configuración unificada
iniciar_sesion_segura();

header('Content-Type: application/json');

$auth = new AuthManager();
$sesion = $auth->verificarSesion();

if ($sesion) {
    echo json_encode([
        'loggedIn' => true,
        'user' => [
            'id' => $sesion['id'] ?? null,
            'usuario' => $sesion['usuario'],
            'nombre' => $sesion['nombre_completo'],
            'rol' => $sesion['rol']
        ]
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>
