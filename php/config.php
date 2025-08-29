<?php
/**
 * Configuración de conexión a la base de datos MySQL
 */

// Configuración de la base de datos
define('DB_HOST', '148.113.206.59');
define('DB_NAME', 'corpor18_rehobot_db');
define('DB_USER', 'corpor18_admin'); 
define('DB_PASS', 'mPiq39Iz06LuDi1T'); 
define('DB_CHARSET', 'utf8mb4');

// Configuración de uploads
define('UPLOAD_PATH', '../uploads/cv/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['pdf', 'doc', 'docx']);

// Configuración de email
define('SMTP_HOST', 'mail.rehobot.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'sistema@rehobot.com');
define('SMTP_PASS', ''); // Configurar después
define('EMAIL_CONTACTO', 'contacto@rehobot.com');
define('EMAIL_RRHH', 'rrhh@rehobot.com');

// Configuración de seguridad
define('SECRET_KEY', 'rehobot_2025_secret_key_change_this'); // Cambiar por una clave única
define('ENCRYPTION_KEY', 'rehobot_encryption_key_2025_change_this_too'); // Para encriptación adicional
define('SESSION_LIFETIME', 8 * 3600); // 8 horas en segundos
define('MAX_LOGIN_ATTEMPTS', 5); // Máximo intentos de login
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutos de bloqueo
define('COOKIE_SECURE', false); // Cambiar a true en HTTPS
define('CSRF_TOKEN_LIFETIME', 3600); // 1 hora para tokens CSRF

/**
 * Clase para manejar la conexión a la base de datos
 */
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            $this->connection->exec("SET NAMES " . DB_CHARSET);
            
        } catch (PDOException $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            // No lanzar excepción para permitir funcionamiento sin BD
            $this->connection = null;
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    /**
     * Verificar si hay conexión a la base de datos
     */
    public function isConnected() {
        return $this->connection !== null;
    }

    /**
     * Ejecutar una consulta preparada
     */
    public function query($sql, $params = []) {
        if (!$this->isConnected()) {
            throw new Exception("No hay conexión a la base de datos");
        }
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Error en consulta: " . $e->getMessage());
            throw new Exception("Error en la consulta a la base de datos");
        }
    }

    /**
     * Insertar un registro y devolver el ID
     */
    public function insert($sql, $params = []) {
        $this->query($sql, $params);
        return $this->connection->lastInsertId();
    }

    /**
     * Obtener un solo registro
     */
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }

    /**
     * Obtener múltiples registros
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }
}

/**
 * Funciones de utilidad
 */

/**
 * Sanitizar entrada de usuario
 */
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validar email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generar token CSRF
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Obtener IP del cliente
 */
function getClientIP() {
    $ipKeys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
    
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// Iniciar sesión si no está iniciada con configuración específica
if (session_status() === PHP_SESSION_NONE) {
    // Configurar parámetros de sesión para desarrollo
    ini_set('session.cookie_secure', '0'); // Permitir HTTP en desarrollo
    ini_set('session.cookie_samesite', 'Lax'); // Menos restrictivo para desarrollo
    ini_set('session.cookie_httponly', '1');
    ini_set('session.gc_maxlifetime', '28800'); // 8 horas
    
    session_start();
}
?>
