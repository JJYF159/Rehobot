<?php
/**
 * API para actualizar estados en el panel de administración
 */

require_once 'config.php';
require_once 'auth.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Verificar autenticación
$auth = new AuthManager();
$sesion = $auth->verificarSesion();

if (!$sesion) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('Datos JSON inválidos');
    }
    
    $id = (int)($input['id'] ?? 0);
    $type = $input['type'] ?? '';
    $status = $input['status'] ?? '';
    
    if (!$id || !$type || !$status) {
        throw new Exception('Faltan parámetros requeridos');
    }
    
    $db = Database::getInstance();
    
    // Validar estados permitidos
    $allowedStatuses = [
        'contactos' => ['nuevo', 'leido', 'respondido'],
        'trabajos' => ['nuevo', 'revision', 'entrevista', 'contratado', 'rechazado']
    ];
    
    $typeKey = $type === 'trabajos' ? 'trabajos' : 'contactos';
    
    if (!in_array($status, $allowedStatuses[$typeKey])) {
        throw new Exception('Estado no válido');
    }
    
    // Actualizar registro
    if ($type === 'contactos') {
        $sql = "UPDATE contactos SET estado = ? WHERE id = ?";
    } elseif ($type === 'trabajos') {
        $sql = "UPDATE aplicaciones_trabajo SET estado = ? WHERE id = ?";
    } else {
        throw new Exception('Tipo no válido');
    }
    
    $db->query($sql, [$status, $id]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Estado actualizado correctamente'
    ]);

} catch (Exception $e) {
    error_log("Error en admin_update.php: " . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
