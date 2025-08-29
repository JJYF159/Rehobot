<?php
require_once 'cookie_auth.php';

header('Content-Type: application/json');

$auth = new CookieAuthManager();
$auth->logout();

echo json_encode(['success' => true, 'message' => 'Logout exitoso']);
?>
