<?php
/**
 * Sistema de autenticación alternativo usando cookies seguras
 */

require_once 'config.php';
require_once 'security.php';

class CookieAuthManager {
    private $db;
    private $security;
    private $cookieName = 'rehobot_admin_auth';
    private $cookieLifetime = 28800; // 8 horas
    
    public function __construct() {
        $dbInstance = Database::getInstance();
        $this->db = $dbInstance->isConnected() ? $dbInstance->getConnection() : null;
        $this->security = new SecurityManager();
    }
    
    /**
     * Login usando cookies en lugar de sesiones
     */
    public function login($usuario, $password) {
        $usuario = $this->security->sanitizeInput($usuario);
        
        // Verificar en base de datos
        if ($this->db) {
            try {
                $query = "SELECT * FROM admin_usuarios WHERE usuario = ? AND activo = 1";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$usuario]);
                $user = $stmt->fetch();
                
                if (!$user || !password_verify($password, $user['password_hash'])) {
                    return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
                }
                
                // Crear token de autenticación
                $authData = [
                    'user_id' => $user['id'],
                    'usuario' => $user['usuario'],
                    'nombre' => $user['nombre_completo'],
                    'rol' => $user['rol'],
                    'timestamp' => time(),
                    'ip' => $_SERVER['REMOTE_ADDR'] ?? ''
                ];
                
                $authToken = $this->createAuthToken($authData);
                
                // Establecer cookie
                $this->setAuthCookie($authToken);
                
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
        } else {
            // Modo demo sin base de datos
            if ($usuario === 'admin' && $password === 'rehobot2025') {
                $authData = [
                    'user_id' => 1,
                    'usuario' => 'admin',
                    'nombre' => 'Administrador',
                    'rol' => 'admin',
                    'timestamp' => time(),
                    'ip' => $_SERVER['REMOTE_ADDR'] ?? ''
                ];
                
                $authToken = $this->createAuthToken($authData);
                $this->setAuthCookie($authToken);
                
                return [
                    'success' => true,
                    'user' => [
                        'id' => 1,
                        'usuario' => 'admin',
                        'nombre' => 'Administrador',
                        'rol' => 'admin'
                    ]
                ];
            }
            
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
        }
    }
    
    /**
     * Verificar autenticación
     */
    public function verificarAuth() {
        $authToken = $_COOKIE[$this->cookieName] ?? null;
        
        if (!$authToken) {
            return false;
        }
        
        $authData = $this->validateAuthToken($authToken);
        
        if (!$authData) {
            $this->clearAuthCookie();
            return false;
        }
        
        // Verificar que no haya expirado
        if ((time() - $authData['timestamp']) > $this->cookieLifetime) {
            $this->clearAuthCookie();
            return false;
        }
        
        // Verificar IP para mayor seguridad
        if ($authData['ip'] !== ($_SERVER['REMOTE_ADDR'] ?? '')) {
            error_log("WARNING: IP mismatch for user " . $authData['usuario']);
            // No cerrar sesión automáticamente por cambio de IP, solo loggear
        }
        
        return [
            'id' => $authData['user_id'],
            'usuario' => $authData['usuario'],
            'nombre_completo' => $authData['nombre'],
            'rol' => $authData['rol']
        ];
    }
    
    /**
     * Logout
     */
    public function logout() {
        $this->clearAuthCookie();
        return true;
    }
    
    /**
     * Crear token de autenticación
     */
    private function createAuthToken($data) {
        $payload = base64_encode(json_encode($data));
        $signature = hash_hmac('sha256', $payload, SECRET_KEY);
        return $payload . '.' . $signature;
    }
    
    /**
     * Validar token de autenticación
     */
    private function validateAuthToken($token) {
        $parts = explode('.', $token);
        
        if (count($parts) !== 2) {
            return false;
        }
        
        list($payload, $signature) = $parts;
        
        // Verificar firma
        $expectedSignature = hash_hmac('sha256', $payload, SECRET_KEY);
        
        if (!hash_equals($expectedSignature, $signature)) {
            return false;
        }
        
        // Decodificar datos
        $data = json_decode(base64_decode($payload), true);
        
        if (!$data || !isset($data['user_id'])) {
            return false;
        }
        
        return $data;
    }
    
    /**
     * Establecer cookie de autenticación
     */
    private function setAuthCookie($token) {
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        
        setcookie(
            $this->cookieName,
            $token,
            time() + $this->cookieLifetime,
            '/',
            '',
            $secure,
            true // httponly
        );
    }
    
    /**
     * Limpiar cookie de autenticación
     */
    private function clearAuthCookie() {
        setcookie(
            $this->cookieName,
            '',
            time() - 3600,
            '/',
            '',
            false,
            true
        );
    }
}
?>
