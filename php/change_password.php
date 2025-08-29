<?php
session_start();
require_once 'config.php';
require_once 'auth.php';
require_once 'security.php';

// Verificar que el usuario esté autenticado
if (!AuthManager::verificarSesion()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

// Solo aceptar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Rate limiting básico - máximo 3 intentos por minuto
if (!isset($_SESSION['password_attempts'])) {
    $_SESSION['password_attempts'] = [];
}

$current_time = time();
$_SESSION['password_attempts'] = array_filter($_SESSION['password_attempts'], function($timestamp) use ($current_time) {
    return ($current_time - $timestamp) < 60;
});

if (count($_SESSION['password_attempts']) >= 3) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Demasiados intentos. Espere un minuto.']);
    exit;
}

// Obtener datos del formulario
$currentPassword = $_POST['currentPassword'] ?? '';
$newPassword = $_POST['newPassword'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

// Validar que todos los campos estén presentes
if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    exit;
}

// Validar que las nuevas contraseñas coincidan
if ($newPassword !== $confirmPassword) {
    $_SESSION['password_attempts'][] = $current_time;
    echo json_encode(['success' => false, 'message' => 'Las nuevas contraseñas no coinciden']);
    exit;
}

// Validar complejidad de la nueva contraseña (mínimo 8 caracteres)
if (strlen($newPassword) < 8) {
    echo json_encode(['success' => false, 'message' => 'La nueva contraseña debe tener al menos 8 caracteres']);
    exit;
}

// Validar que tenga mayúsculas, minúsculas, números y símbolos
if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/', $newPassword)) {
    echo json_encode(['success' => false, 'message' => 'La contraseña debe incluir mayúsculas, minúsculas, números y símbolos']);
    exit;
}

try {
    $db = Database::getInstance();
    $userId = $_SESSION['admin_id'] ?? $_SESSION['admin_user_id'];
    
    // Verificar la contraseña actual
    $stmt = $db->prepare("SELECT password FROM admin_usuarios WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user || !password_verify($currentPassword, $user['password'])) {
        $_SESSION['password_attempts'][] = $current_time;
        
        // Log del intento fallido
        if ($db) {
            $stmt = $db->prepare("INSERT INTO admin_logs (admin_id, accion, detalles, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $userId,
                'cambio_password_failed',
                'Intento fallido - contraseña actual incorrecta',
                $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
        }
        
        echo json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta']);
        exit;
    }
    
    // Verificar que la nueva contraseña sea diferente a la actual
    if (password_verify($newPassword, $user['password'])) {
        echo json_encode(['success' => false, 'message' => 'La nueva contraseña debe ser diferente a la actual']);
        exit;
    }
    
    // Actualizar la contraseña con algoritmo más seguro
    $options = [
        'cost' => 12, // Mayor costo computacional para más seguridad
    ];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT, $options);
    
    $stmt = $db->prepare("UPDATE admin_usuarios SET password = ?, updated_at = NOW() WHERE id = ?");
    $result = $stmt->execute([$hashedPassword, $userId]);
    
    if ($result) {
        // Limpiar intentos fallidos tras éxito
        unset($_SESSION['password_attempts']);
        
        // Registrar el cambio exitoso en el log
        $stmt = $db->prepare("INSERT INTO admin_logs (admin_id, accion, detalles, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $userId,
            'cambio_password_success',
            'Contraseña cambiada exitosamente',
            $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
        
        echo json_encode(['success' => true, 'message' => 'Contraseña cambiada exitosamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al cambiar la contraseña']);
    }
    
} catch (Exception $e) {
    error_log("Error al cambiar contraseña: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}
?>
