<?php
/**
 * API para estadísticas del panel de administración
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

try {
    $db = Database::getInstance();
    
    // Debug: Verificar conexión
    error_log("Admin Stats: Iniciando obtención de estadísticas");
    
    // Estadísticas de contactos con manejo de errores
    $totalContactos = 0;
    $contactosNuevos = 0;
    try {
        $result = $db->fetchOne("SELECT COUNT(*) as total FROM contactos");
        $totalContactos = $result ? (int)$result['total'] : 0;
        error_log("Admin Stats: Total contactos = " . $totalContactos);
        
        $result = $db->fetchOne("SELECT COUNT(*) as total FROM contactos WHERE estado = 'nuevo'");
        $contactosNuevos = $result ? (int)$result['total'] : 0;
        error_log("Admin Stats: Contactos nuevos = " . $contactosNuevos);
    } catch (Exception $e) {
        error_log("Error obteniendo estadísticas de contactos: " . $e->getMessage());
    }
    
    // Estadísticas de aplicaciones con manejo de errores
    $totalAplicaciones = 0;
    $aplicacionesProceso = 0;
    try {
        $result = $db->fetchOne("SELECT COUNT(*) as total FROM aplicaciones_trabajo");
        $totalAplicaciones = $result ? (int)$result['total'] : 0;
        error_log("Admin Stats: Total aplicaciones = " . $totalAplicaciones);
        
        $result = $db->fetchOne("SELECT COUNT(*) as total FROM aplicaciones_trabajo WHERE estado IN ('revision', 'entrevista')");
        $aplicacionesProceso = $result ? (int)$result['total'] : 0;
        error_log("Admin Stats: Aplicaciones en proceso = " . $aplicacionesProceso);
    } catch (Exception $e) {
        error_log("Error obteniendo estadísticas de aplicaciones: " . $e->getMessage());
    }
    
    // Contactos por mes (últimos 6 meses)
    $contactosPorMes = [];
    try {
        $contactosPorMes = $db->fetchAll("
            SELECT 
                DATE_FORMAT(fecha_envio, '%Y-%m') as mes,
                COUNT(*) as total
            FROM contactos 
            WHERE fecha_envio >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(fecha_envio, '%Y-%m')
            ORDER BY mes DESC
        ");
    } catch (Exception $e) {
        error_log("Error obteniendo contactos por mes: " . $e->getMessage());
    }
    
    // Aplicaciones por mes (últimos 6 meses)
    $aplicacionesPorMes = [];
    try {
        $aplicacionesPorMes = $db->fetchAll("
            SELECT 
                DATE_FORMAT(fecha_envio, '%Y-%m') as mes,
                COUNT(*) as total
            FROM aplicaciones_trabajo 
            WHERE fecha_envio >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY DATE_FORMAT(fecha_envio, '%Y-%m')
            ORDER BY mes DESC
        ");
    } catch (Exception $e) {
        error_log("Error obteniendo aplicaciones por mes: " . $e->getMessage());
    }
    
    // Servicios más consultados
    $serviciosMasConsultados = [];
    try {
        $serviciosMasConsultados = $db->fetchAll("
            SELECT 
                servicio,
                COUNT(*) as total
            FROM contactos 
            WHERE servicio IS NOT NULL AND servicio != ''
            GROUP BY servicio
            ORDER BY total DESC
            LIMIT 5
        ");
    } catch (Exception $e) {
        error_log("Error obteniendo servicios más consultados: " . $e->getMessage());
    }
    
    // Puestos más aplicados
    $puestosMasAplicados = [];
    try {
        $puestosMasAplicados = $db->fetchAll("
            SELECT 
                puesto,
                COUNT(*) as total
            FROM aplicaciones_trabajo 
            GROUP BY puesto
            ORDER BY total DESC
            LIMIT 5
        ");
    } catch (Exception $e) {
        error_log("Error obteniendo puestos más aplicados: " . $e->getMessage());
    }
    
    $response = [
        'total_contactos' => $totalContactos,
        'contactos_nuevos' => $contactosNuevos,
        'total_aplicaciones' => $totalAplicaciones,
        'aplicaciones_proceso' => $aplicacionesProceso,
        'contactos_por_mes' => $contactosPorMes,
        'aplicaciones_por_mes' => $aplicacionesPorMes,
        'servicios_mas_consultados' => $serviciosMasConsultados,
        'puestos_mas_aplicados' => $puestosMasAplicados,
        'debug' => [
            'timestamp' => date('Y-m-d H:i:s'),
            'total_contactos_debug' => $totalContactos,
            'contactos_nuevos_debug' => $contactosNuevos,
            'total_aplicaciones_debug' => $totalAplicaciones,
            'aplicaciones_proceso_debug' => $aplicacionesProceso
        ]
    ];
    
    error_log("Admin Stats: Respuesta final = " . json_encode($response));
    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error en admin_stats.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error obteniendo estadísticas']);
}
?>
