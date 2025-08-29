<?php
/**
 * API para eliminar registros en el panel de administración
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
    
    if (!$id || !$type) {
        throw new Exception('Faltan parámetros requeridos');
    }
    
    $db = Database::getInstance();
    
    // Eliminar registro según el tipo
    if ($type === 'contactos') {
        // Verificar que el registro existe
        $exists = $db->fetchOne("SELECT id FROM contactos WHERE id = ?", [$id]);
        
        if (!$exists) {
            throw new Exception('Registro no encontrado');
        }
        
        // Eliminar
        $db->query("DELETE FROM contactos WHERE id = ?", [$id]);
        
        // Si no quedan registros, reiniciar autoincrement
        $count = $db->fetchOne("SELECT COUNT(*) as total FROM contactos")['total'];
        if ($count == 0) {
            $db->query("ALTER TABLE contactos AUTO_INCREMENT = 1");
        }
        
    } elseif ($type === 'trabajos') {
        // Verificar que el registro existe y obtener info del archivo
        $record = $db->fetchOne("SELECT id, cv_archivo FROM aplicaciones_trabajo WHERE id = ?", [$id]);
        
        if (!$record) {
            throw new Exception('Registro no encontrado');
        }
        
        // Eliminar archivo CV si existe
        if ($record['cv_archivo']) {
            $filePath = UPLOAD_PATH . $record['cv_archivo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Eliminar registro
        $db->query("DELETE FROM aplicaciones_trabajo WHERE id = ?", [$id]);
        
        // Si no quedan registros, reiniciar autoincrement
        $count = $db->fetchOne("SELECT COUNT(*) as total FROM aplicaciones_trabajo")['total'];
        if ($count == 0) {
            $db->query("ALTER TABLE aplicaciones_trabajo AUTO_INCREMENT = 1");
        }
        
    } else {
        throw new Exception('Tipo no válido');
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Registro eliminado correctamente'
    ]);

} catch (Exception $e) {
    error_log("Error en admin_delete.php: " . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
