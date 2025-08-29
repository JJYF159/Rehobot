<?php
require_once 'cookie_auth.php';

header('Content-Type: application/json');

$auth = new CookieAuthManager();
$userData = $auth->verificarAuth();

if ($userData) {
    echo json_encode([
        'loggedIn' => true,
        'user' => [
            'id' => $userData['id'] ?? null,
            'usuario' => $userData['usuario'],
            'nombre' => $userData['nombre_completo'],
            'rol' => $userData['rol']
        ]
    ]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>
