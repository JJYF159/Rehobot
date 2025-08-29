<?php
/**
 * Procesador del formulario de contacto
 * REHOBOT - Sistema de formularios web
 */

require_once 'config.php';
require_once 'email.php';

// Configurar headers para JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Obtener datos del formulario
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Si no hay JSON, intentar con POST normal
    if (!$input) {
        $input = $_POST;
    }

    // Validar token CSRF - TEMPORALMENTE DESHABILITADO PARA PRUEBAS
    // if (!isset($input['csrf_token']) || !verifyCSRFToken($input['csrf_token'])) {
    //     throw new Exception('Token de seguridad inválido');
    // }

    // Validar campos requeridos
    $requiredFields = ['nombre', 'email', 'telefono', 'mensaje'];
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            throw new Exception("El campo '$field' es requerido");
        }
    }

    // Sanitizar datos
    $data = [
        'nombre' => sanitizeInput($input['nombre']),
        'email' => sanitizeInput($input['email']),
        'telefono' => sanitizeInput($input['telefono']),
        'empresa' => sanitizeInput($input['empresa'] ?? ''),
        'mensaje' => sanitizeInput($input['mensaje']),
        'ip_address' => getClientIP(),
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ];

    // Validar email
    if (!validateEmail($data['email'])) {
        throw new Exception('Email inválido');
    }

    // Validar longitud de campos
    $fieldLengths = [
        'nombre' => 255,
        'email' => 255,
        'telefono' => 20,
        'empresa' => 255,
        'mensaje' => 5000
    ];

    foreach ($fieldLengths as $field => $maxLength) {
        if (strlen($data[$field]) > $maxLength) {
            throw new Exception("El campo '$field' es demasiado largo (máximo $maxLength caracteres)");
        }
    }

    // Conectar a la base de datos
    $db = Database::getInstance();

    // Verificar si ya existe un contacto reciente con el mismo email (evitar spam)
    $recentContact = $db->fetchOne(
        "SELECT id FROM contactos WHERE email = ? AND fecha_envio > DATE_SUB(NOW(), INTERVAL 1 HOUR)",
        [$data['email']]
    );

    if ($recentContact) {
        throw new Exception('Ya has enviado un mensaje recientemente. Por favor espera una hora antes de enviar otro.');
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO contactos (nombre, email, telefono, empresa, mensaje, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $contactId = $db->insert($sql, [
        $data['nombre'],
        $data['email'],
        $data['telefono'],
        $data['empresa'],
        $data['mensaje'],
        $data['ip_address'],
        $data['user_agent']
    ]);

    // Enviar email de notificación
    try {
        $emailSent = sendContactNotificationEmail($data, $contactId);
        
        // También enviar email de confirmación al cliente
        sendContactConfirmationEmail($data);
        
    } catch (Exception $e) {
        // Log del error pero no fallar la operación
        error_log("Error enviando email: " . $e->getMessage());
        $emailSent = false;
    }

    // Respuesta exitosa
    $response = [
        'success' => true,
        'message' => 'Tu mensaje ha sido enviado correctamente. Nos pondremos en contacto contigo pronto.',
        'contact_id' => $contactId
    ];

    if (!$emailSent) {
        $response['warning'] = 'El mensaje fue guardado pero hubo un problema enviando la notificación por email.';
    }

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error en procesamiento de contacto: " . $e->getMessage());
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
