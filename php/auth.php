<?php
require_once 'config.php';
require_once 'security.php';
require_once 'session_config.php';

class AuthManager {
    private $db;
    private $security;
    private $usuarios_demo = [
        'admin' => [
            'password' => 'rehobot2025',
            'nombre_completo' => 'Administrador',
            'rol' => 'admin',
            'activo' => 1
        ]
    ];
    
    public function __construct() {
        $dbInstance = Database::getInstance();
        $this->db = $dbInstance->isConnected() ? $dbInstance->getConnection() : null;
        $this->security = new SecurityManager();
    }
    
    // Verificar sesión activa
    public function verificarSesion() {
        // Iniciar sesión usando configuración unificada
        iniciar_sesion_segura();
        
        // Verificar que hay datos básicos de sesión
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            return false;
        }
        
        // Modo demo sin base de datos
        if (!$this->db) {
            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                return [
                    'id' => $_SESSION['admin_user_id'] ?? null,
                    'usuario' => $_SESSION['admin_user'] ?? 'admin',
                    'nombre_completo' => $_SESSION['admin_nombre'] ?? 'Administrador',
                    'rol' => $_SESSION['admin_rol'] ?? 'admin',
                    'activo' => 1
                ];
            }
            return false;
        }
        
        // Modo con base de datos
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            // Verificar que el usuario aún existe y está activo en la BD
            if (isset($_SESSION['admin_user_id'])) {
                try {
                    $query = "SELECT id, usuario, nombre_completo, rol, activo FROM admin_usuarios WHERE id = ? AND activo = 1";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$_SESSION['admin_user_id']]);
                    $user = $stmt->fetch();
                    
                    if ($user) {
                        // Actualizar último acceso
                        $this->actualizarUltimoAcceso($user['id']);
                        return $user;
                    }
                } catch (PDOException $e) {
                    error_log("Error verificando sesión: " . $e->getMessage());
                }
            }
            
            // Si llegamos aquí, la sesión es inválida
            $this->logout();
            return false;
        }
        
        return false;
    }
    
    // Login de usuario
    public function login($usuario, $password) {
        // Iniciar sesión usando configuración unificada
        iniciar_sesion_segura();
        
        // Sanitizar entrada
        $usuario = $this->security->sanitizeInput($usuario);
        
        // Rate limiting
        $identifier = $_SERVER['REMOTE_ADDR'] . '_' . $usuario;
        if (!$this->security->checkRateLimit($identifier, MAX_LOGIN_ATTEMPTS, LOGIN_LOCKOUT_TIME)) {
            $this->security->logSecurityEvent('login_rate_limit_exceeded', "User: $usuario", 'WARNING');
            return ['success' => false, 'message' => 'Demasiados intentos. Intente nuevamente en 15 minutos.'];
        }
        
        // Si no hay base de datos, usar modo demo
        if (!$this->db) {
            if (isset($this->usuarios_demo[$usuario]) && $this->usuarios_demo[$usuario]['password'] === $password) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $usuario;
                $_SESSION['admin_nombre'] = $this->usuarios_demo[$usuario]['nombre_completo'];
                $_SESSION['admin_rol'] = $this->usuarios_demo[$usuario]['rol'];
                $_SESSION['admin_user_id'] = 1; // ID ficticio para modo demo
                $_SESSION['admin_login_time'] = time();
                
                return [
                    'success' => true,
                    'user' => [
                        'id' => 1,
                        'usuario' => $usuario,
                        'nombre' => $this->usuarios_demo[$usuario]['nombre_completo'],
                        'rol' => $this->usuarios_demo[$usuario]['rol']
                    ]
                ];
            }
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
        }
        
        // Verificar usuario en base de datos
        try {
            $query = "SELECT * FROM admin_usuarios WHERE usuario = ? AND activo = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$usuario]);
            $user = $stmt->fetch();
            
            if (!$user) {
                $this->registrarLog(null, 'login_fallido', "Usuario inexistente: $usuario");
                $this->security->logSecurityEvent('login_failed', "Non-existent user: $usuario", 'WARNING');
                return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
            }
            
            // Verificar contraseña
            if (!password_verify($password, $user['password_hash'])) {
                $this->registrarLog($user['id'], 'login_fallido', 'Contraseña incorrecta');
                $this->security->logSecurityEvent('login_failed', "Wrong password for user: $usuario", 'WARNING');
                return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
            }
            
            // Limpiar rate limit en login exitoso
            $this->security->clearRateLimit($identifier);
            
            // Crear sesión PHP
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user_id'] = $user['id'];
            $_SESSION['admin_user'] = $user['usuario'];
            $_SESSION['admin_nombre'] = $user['nombre_completo'];
            $_SESSION['admin_rol'] = $user['rol'];
            $_SESSION['admin_login_time'] = time();
            
            // Registrar sesión en base de datos (opcional, para auditoría)
            $token = $this->security->generateSecureToken();
            $expiracion = date('Y-m-d H:i:s', time() + SESSION_LIFETIME);
            
            $query = "INSERT INTO admin_sesiones (usuario_id, token_sesion, ip_address, user_agent, fecha_expiracion) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                $user['id'],
                $token,
                $_SERVER['REMOTE_ADDR'] ?? '',
                $_SERVER['HTTP_USER_AGENT'] ?? '',
                $expiracion
            ]);
            
            $this->registrarLog($user['id'], 'login_exitoso', 'Login exitoso');
            $this->security->logSecurityEvent('login_success', "User: $usuario");
            
            return [
                'success' => true,
                'user' => [
                    'id' => $user['id'],
                    'usuario' => $user['usuario'],
                    'nombre' => $user['nombre_completo'],
                    'rol' => $user['rol']
                ]
            ];
            
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error interno del servidor'];
        }
    }
    
    // Logout
    public function logout() {
        // Iniciar sesión usando configuración unificada
        iniciar_sesion_segura();

        // Cierre global: desactiva todas las sesiones del usuario en la base de datos
        if ($this->db && isset($_SESSION['admin_user_id'])) {
            try {
                // Cierra todas las sesiones del usuario
                $query = "UPDATE admin_sesiones SET activa = 0 WHERE usuario_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$_SESSION['admin_user_id']]);

                $this->registrarLog($_SESSION['admin_user_id'], 'logout_global', 'Logout global exitoso');
                $this->security->logSecurityEvent('logout_success', 'User logged out globally');
            } catch (Exception $e) {
                error_log("Error registrando logout global: " . $e->getMessage());
            }
        }

        // Limpiar todas las variables de sesión
        $_SESSION = array();

        // Destruir la cookie de sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destruir la sesión
        session_destroy();

        // Limpiar token CSRF
        $this->security->clearCSRFToken();

        return true;
    }
    
    // Cambiar contraseña
    public function cambiarPassword($usuarioId, $passwordActual, $passwordNuevo) {
        // Verificar contraseña actual
        $query = "SELECT password_hash FROM admin_usuarios WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuarioId]);
        $user = $stmt->fetch();
        
        if (!$user || !password_verify($passwordActual, $user['password_hash'])) {
            return ['success' => false, 'message' => 'Contraseña actual incorrecta'];
        }
        
        // Actualizar contraseña
        $hashedPassword = password_hash($passwordNuevo, PASSWORD_DEFAULT);
        $query = "UPDATE admin_usuarios SET password_hash = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$hashedPassword, $usuarioId]);
        
        $this->registrarLog($usuarioId, 'cambio_password', 'Contraseña cambiada');
        
        return ['success' => true, 'message' => 'Contraseña actualizada correctamente'];
    }
    
    // Limpiar sesiones expiradas
    public function limpiarSesionesExpiradas() {
        $query = "DELETE FROM admin_sesiones WHERE fecha_expiracion < NOW() OR activa = 0";
        $stmt = $this->db->prepare($query);
        return $stmt->execute();
    }
    
    // Actualizar último acceso
    private function actualizarUltimoAcceso($usuarioId) {
        $query = "UPDATE admin_usuarios SET ultimo_acceso = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuarioId]);
    }
    
    // Registrar log de actividad
    private function registrarLog($usuarioId, $accion, $detalles = '') {
        $query = "INSERT INTO admin_logs (usuario_id, accion, detalles, ip_address, user_agent) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            $usuarioId,
            $accion,
            $detalles,
            $_SERVER['REMOTE_ADDR'] ?? '',
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        ]);
    }
    
    // Crear nuevo usuario admin
    public function crearUsuario($usuario, $password, $nombreCompleto, $email, $rol = 'operador') {
        // Sanitizar entradas
        $usuario = $this->security->sanitizeInput($usuario);
        $nombreCompleto = $this->security->sanitizeInput($nombreCompleto);
        $email = $this->security->sanitizeInput($email);
        $rol = $this->security->sanitizeInput($rol);
        
        // Validar fortaleza de contraseña
        $passwordValidation = $this->security->validatePasswordStrength($password);
        if (!$passwordValidation['valid']) {
            return [
                'success' => false, 
                'message' => 'Contraseña no cumple los requisitos: ' . implode(', ', $passwordValidation['errors'])
            ];
        }
        
        // Verificar que no existe
        $query = "SELECT id FROM admin_usuarios WHERE usuario = ? OR email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuario, $email]);
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Usuario o email ya existe'];
        }
        
        // Crear usuario
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin_usuarios (usuario, password_hash, nombre_completo, email, rol) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuario, $hashedPassword, $nombreCompleto, $email, $rol]);
        
        $this->registrarLog(null, 'crear_usuario', "Usuario creado: $usuario");
        $this->security->logSecurityEvent('user_created', "New user: $usuario");
        
        return ['success' => true, 'message' => 'Usuario creado correctamente'];
    }
    
    // Generar token CSRF
    public function generateCSRFToken() {
        return $this->security->generateCSRFToken();
    }
    
    // Verificar token CSRF
    public function verifyCSRFToken($token) {
        return $this->security->verifyCSRFToken($token);
    }
    
    // Verificar fuerza de contraseña
    public function validatePasswordStrength($password) {
        return $this->security->validatePasswordStrength($password);
    }
    
    // Obtener logs de seguridad del usuario
    public function getSecurityLogs($usuarioId, $limit = 50) {
        $query = "SELECT * FROM admin_logs WHERE usuario_id = ? ORDER BY fecha DESC LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuarioId, $limit]);
        return $stmt->fetchAll();
    }
    
    // Método para registrar logs de acciones específicas (público)
    public function logAdminAction($usuarioId, $accion, $detalles = '') {
        $this->registrarLog($usuarioId, $accion, $detalles);
        $this->security->logSecurityEvent('admin_action', "$accion: $detalles");
    }
}
?>
