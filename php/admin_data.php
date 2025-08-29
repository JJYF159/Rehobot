<?php
/**
 * API para obtener datos del panel de administración
 */

require_once 'config.php';
require_once 'auth.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Verificar autenticación
$auth = new AuthManager();
$sesion = $auth->verificarSesion();

if (!$sesion) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Solo permitir GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

try {
    $type = $_GET['type'] ?? 'contactos';
    $limit = min((int)($_GET['limit'] ?? 100), 500); // Máximo 500 registros
    $offset = (int)($_GET['offset'] ?? 0);
    
    $db = Database::getInstance();
    
    if ($type === 'contactos') {
        // Obtener contactos
        $sql = "SELECT 
                    id, 
                    nombre, 
                    email, 
                    telefono, 
                    empresa, 
                    mensaje, 
                    fecha_envio, 
                    estado,
                    ip_address
                FROM contactos 
                ORDER BY fecha_envio DESC 
                LIMIT ? OFFSET ?";
        
        $data = $db->fetchAll($sql, [$limit, $offset]);
        
    } elseif ($type === 'trabajos') {
        // Obtener aplicaciones de trabajo
        $sql = "SELECT 
                    id, 
                    nombre, 
                    email, 
                    telefono, 
                    carrera, 
                    puesto, 
                    cv_archivo,
                    cv_nombre_original,
                    cv_tamaño_kb,
                    fecha_envio, 
                    estado,
                    ip_address
                FROM aplicaciones_trabajo 
                ORDER BY fecha_envio DESC 
                LIMIT ? OFFSET ?";
        
        $data = $db->fetchAll($sql, [$limit, $offset]);
        
    } else {
        throw new Exception('Tipo de datos no válido');
    }
    
    echo json_encode($data);

} catch (Exception $e) {
    error_log("Error en admin_data.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error obteniendo datos: ' . $e->getMessage()]);
}
?>
