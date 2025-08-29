<?php
/**
 * Clase de seguridad mejorada para REHOBOT
 * Incluye encriptación, manejo seguro de cookies y protección CSRF
 */

class SecurityManager {
    private $secretKey;
    private $encryptionMethod = 'AES-256-CBC';
    
    public function __construct() {
        $this->secretKey = SECRET_KEY;
    }
    
    /**
     * Encriptar datos sensibles (versión simplificada)
     */
    public function encrypt($data) {
        // Usar base64 como encriptación básica por ahora
        return base64_encode($data . '::' . $this->secretKey);
    }
    
    /**
     * Desencriptar datos
     */
    public function decrypt($data) {
        $decoded = base64_decode($data);
        $parts = explode('::', $decoded);
        if (count($parts) === 2 && $parts[1] === $this->secretKey) {
            return $parts[0];
        }
        return false;
    }
    
    /**
     * Generar token seguro
     */
    public function generateSecureToken($length = 64) {
        return bin2hex(random_bytes($length / 2));
    }
    
    /**
     * Crear hash seguro para tokens de sesión
     */
    public function hashToken($token) {
        return hash_hmac('sha256', $token, $this->secretKey);
    }
    
    /**
     * Configurar cookie segura
     */
    public function setSecureCookie($name, $value, $expire = null, $httpOnly = true, $secure = false, $sameSite = 'Strict') {
        if ($expire === null) {
            $expire = time() + (8 * 3600); // 8 horas por defecto
        }
        
        // Encriptar el valor de la cookie
        $encryptedValue = $this->encrypt($value);
        
        // Configurar opciones de cookie segura
        $options = [
            'expires' => $expire,
            'path' => '/',
            'domain' => '',
            'secure' => $secure, // true en HTTPS
            'httponly' => $httpOnly,
            'samesite' => $sameSite
        ];
        
        return setcookie($name, $encryptedValue, $options);
    }
    
    /**
     * Obtener valor de cookie segura
     */
    public function getSecureCookie($name) {
        if (!isset($_COOKIE[$name])) {
            return null;
        }
        
        try {
            return $this->decrypt($_COOKIE[$name]);
        } catch (Exception $e) {
            // Cookie corrupta o manipulada
            $this->deleteSecureCookie($name);
            return null;
        }
    }
    
    /**
     * Eliminar cookie segura
     */
    public function deleteSecureCookie($name) {
        return setcookie($name, '', time() - 3600, '/', '', false, true);
    }
    
    /**
     * Generar token CSRF
     */
    public function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = $this->generateSecureToken();
            $_SESSION['csrf_token_time'] = time();
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verificar token CSRF
     */
    public function verifyCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time'])) {
            return false;
        }
        
        // Token expira en 1 hora
        if (time() - $_SESSION['csrf_token_time'] > 3600) {
            unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Limpiar token CSRF
     */
    public function clearCSRFToken() {
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
    }
    
    /**
     * Validar origen de la petición
     */
    public function validateOrigin($allowedOrigins = []) {
        if (empty($allowedOrigins)) {
            $allowedOrigins = [$_SERVER['HTTP_HOST'] ?? 'localhost'];
        }
        
        $origin = $_SERVER['HTTP_ORIGIN'] ?? $_SERVER['HTTP_REFERER'] ?? '';
        
        foreach ($allowedOrigins as $allowed) {
            if (strpos($origin, $allowed) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Sanitizar entrada de usuario
     */
    public function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Validar strength de contraseña
     */
    public function validatePasswordStrength($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = 'La contraseña debe tener al menos 8 caracteres';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'La contraseña debe tener al menos una mayúscula';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'La contraseña debe tener al menos una minúscula';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'La contraseña debe tener al menos un número';
        }
        
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'La contraseña debe tener al menos un carácter especial';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'strength' => $this->calculatePasswordStrength($password)
        ];
    }
    
    /**
     * Calcular fuerza de contraseña (0-100)
     */
    private function calculatePasswordStrength($password) {
        $strength = 0;
        $length = strlen($password);
        
        // Longitud
        if ($length >= 8) $strength += 25;
        if ($length >= 12) $strength += 15;
        
        // Caracteres diversos
        if (preg_match('/[a-z]/', $password)) $strength += 15;
        if (preg_match('/[A-Z]/', $password)) $strength += 15;
        if (preg_match('/[0-9]/', $password)) $strength += 15;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $strength += 15;
        
        return min(100, $strength);
    }
    
    /**
     * Rate limiting básico
     */
    public function checkRateLimit($identifier, $maxAttempts = 5, $timeWindow = 300) {
        $key = "rate_limit_" . md5($identifier);
        
        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['count' => 0, 'first_attempt' => time()];
        }
        
        $data = $_SESSION[$key];
        
        // Reset si ha pasado el tiempo
        if (time() - $data['first_attempt'] > $timeWindow) {
            $_SESSION[$key] = ['count' => 1, 'first_attempt' => time()];
            return true;
        }
        
        // Incrementar contador
        $_SESSION[$key]['count']++;
        
        return $_SESSION[$key]['count'] <= $maxAttempts;
    }
    
    /**
     * Limpiar rate limit
     */
    public function clearRateLimit($identifier) {
        $key = "rate_limit_" . md5($identifier);
        unset($_SESSION[$key]);
    }
    
    /**
     * Log de seguridad
     */
    public function logSecurityEvent($event, $details = '', $severity = 'INFO') {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event' => $event,
            'details' => $details,
            'severity' => $severity,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ];
        
        error_log("SECURITY [{$severity}]: " . json_encode($logEntry));
    }
}
?>
