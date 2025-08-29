<?php
/**
 * Procesador del formulario de aplicaciones de trabajo
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
    // Verificar token CSRF - TEMPORALMENTE DESHABILITADO PARA PRUEBAS
    // if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    //     throw new Exception('Token de seguridad inválido');
    // }

    // Validar campos requeridos
    $requiredFields = ['nombre', 'email', 'telefono', 'carrera', 'puesto'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("El campo '$field' es requerido");
        }
    }

    // Sanitizar datos
    $data = [
        'nombre' => sanitizeInput($_POST['nombre']),
        'email' => sanitizeInput($_POST['email']),
        'telefono' => sanitizeInput($_POST['telefono']),
        'carrera' => sanitizeInput($_POST['carrera']),
        'puesto' => sanitizeInput($_POST['puesto']),
        'experiencia' => sanitizeInput($_POST['detalle'] ?? ''),
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
        'carrera' => 255,
        'puesto' => 255
    ];

    foreach ($fieldLengths as $field => $maxLength) {
        if (strlen($data[$field]) > $maxLength) {
            throw new Exception("El campo '$field' es demasiado largo (máximo $maxLength caracteres)");
        }
    }

    // Procesar archivo CV
    $cvInfo = null;
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] !== UPLOAD_ERR_NO_FILE) {
        $cvInfo = processCV($_FILES['cv']);
        if (!$cvInfo) {
            throw new Exception('Error procesando el archivo CV');
        }
    }

    // Conectar a la base de datos
    $db = Database::getInstance();

    // Verificar si ya existe una aplicación reciente con el mismo email
    $recentApplication = $db->fetchOne(
        "SELECT id FROM aplicaciones_trabajo WHERE email = ? AND fecha_envio > DATE_SUB(NOW(), INTERVAL 24 HOUR)",
        [$data['email']]
    );

    if ($recentApplication) {
        throw new Exception('Ya has enviado una aplicación recientemente. Por favor espera 24 horas antes de enviar otra.');
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO aplicaciones_trabajo (nombre, email, telefono, carrera, puesto, experiencia, cv_archivo, cv_nombre_original, cv_tamaño_kb, ip_address, user_agent) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $applicationId = $db->insert($sql, [
        $data['nombre'],
        $data['email'],
        $data['telefono'],
        $data['carrera'],
        $data['puesto'],
        $data['experiencia'],
        $cvInfo['filename'] ?? null,
        $cvInfo['original_name'] ?? null,
        $cvInfo['size_kb'] ?? null,
        $data['ip_address'],
        $data['user_agent']
    ]);

    // Enviar email de notificación
    try {
        $emailSent = sendJobApplicationNotificationEmail($data, $cvInfo, $applicationId);
        
        // También enviar email de confirmación al aplicante
        sendJobApplicationConfirmationEmail($data);
        
    } catch (Exception $e) {
        // Log del error pero no fallar la operación
        error_log("Error enviando email: " . $e->getMessage());
        $emailSent = false;
    }

    // Respuesta exitosa
    $response = [
        'success' => true,
        'message' => 'Tu aplicación ha sido enviada correctamente. Nos pondremos en contacto contigo pronto.',
        'application_id' => $applicationId
    ];

    if (!$emailSent) {
        $response['warning'] = 'La aplicación fue guardada pero hubo un problema enviando la notificación por email.';
    }

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error en procesamiento de aplicación: " . $e->getMessage());
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

/**
 * Procesar archivo CV
 */
function processCV($file) {
    // Verificar errores de upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error subiendo el archivo CV');
    }

    // Verificar tamaño
    if ($file['size'] > MAX_FILE_SIZE) {
        throw new Exception('El archivo CV es demasiado grande (máximo 5MB)');
    }

    // Verificar extensión
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, ALLOWED_EXTENSIONS)) {
        throw new Exception('Formato de archivo no permitido. Solo se permiten: PDF, DOC, DOCX');
    }

    // Crear directorio si no existe
    if (!is_dir(UPLOAD_PATH)) {
        if (!mkdir(UPLOAD_PATH, 0755, true)) {
            throw new Exception('Error creando directorio de uploads');
        }
    }

    // Generar nombre único para el archivo
    $filename = uniqid('cv_', true) . '.' . $extension;
    $filepath = UPLOAD_PATH . $filename;

    // Mover archivo
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new Exception('Error guardando el archivo CV');
    }

    return [
        'filename' => $filename,
        'original_name' => $file['name'],
        'size_kb' => round($file['size'] / 1024),
        'extension' => $extension,
        'path' => $filepath
    ];
}
?>
