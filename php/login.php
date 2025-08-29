<?php
require_once 'session_config.php';
require_once 'auth.php';

// Iniciar sesión con configuración unificada
iniciar_sesion_segura();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($usuario) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Usuario y contraseña son requeridos']);
    exit;
}

$auth = new AuthManager();
$result = $auth->login($usuario, $password);

echo json_encode($result);
?>
