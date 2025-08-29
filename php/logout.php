<?php
require_once 'auth.php';

header('Content-Type: application/json');

$auth = new AuthManager();
$auth->logout();

echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
?>
