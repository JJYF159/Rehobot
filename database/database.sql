-- Base de datos para REHOBOT
CREATE DATABASE IF NOT EXISTS rehobot_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE rehobot_db;

-- Tabla para formulario de contacto
CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    empresa VARCHAR(255),
    mensaje TEXT,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('nuevo', 'leido', 'respondido') DEFAULT 'nuevo',
    ip_address VARCHAR(45),
    user_agent TEXT
);

-- Tabla para aplicaciones de trabajo
CREATE TABLE aplicaciones_trabajo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    carrera VARCHAR(255) NOT NULL,
    puesto VARCHAR(255) NOT NULL,
    cv_archivo VARCHAR(500),
    cv_nombre_original VARCHAR(255),
    cv_tamaño_kb INT,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('nuevo', 'revision', 'entrevista', 'rechazado', 'contratado') DEFAULT 'nuevo',
    ip_address VARCHAR(45),
    user_agent TEXT
);

-- Tabla para configuración del sistema
CREATE TABLE configuracion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descripcion TEXT,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla para usuarios administradores
CREATE TABLE admin_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'supervisor', 'operador') DEFAULT 'operador',
    activo BOOLEAN DEFAULT TRUE,
    ultimo_acceso TIMESTAMP NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla para sesiones de administradores
CREATE TABLE admin_sesiones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token_sesion VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP NULL,
    activa BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (usuario_id) REFERENCES admin_usuarios(id) ON DELETE CASCADE
);

-- Tabla para logs de acceso al admin
CREATE TABLE admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    accion VARCHAR(100) NOT NULL,
    detalles TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES admin_usuarios(id) ON DELETE SET NULL
);

-- Insertar configuraciones básicas
INSERT INTO configuracion (clave, valor, descripcion) VALUES
('email_contacto', 'contacto@rehobot.com', 'Email donde llegan los formularios de contacto'),
('email_rrhh', 'rrhh@rehobot.com', 'Email donde llegan las aplicaciones de trabajo'),
('smtp_host', 'mail.rehobot.com', 'Servidor SMTP para envío de emails'),
('smtp_puerto', '587', 'Puerto SMTP'),
('smtp_usuario', 'sistema@rehobot.com', 'Usuario SMTP'),
('smtp_password', '', 'Contraseña SMTP (configurar después)'),
('empresa_nombre', 'Corporación REHOBOT', 'Nombre de la empresa'),
('max_cv_size_mb', '5', 'Tamaño máximo de CV en MB'),
('sesion_duracion_horas', '8', 'Duración de sesiones admin en horas'),
('intentos_login_max', '5', 'Máximo intentos de login antes de bloqueo');

-- Crear usuario administrador por defecto
-- Usuario: admin, Contraseña: rehobot2025
INSERT INTO admin_usuarios (usuario, password_hash, nombre_completo, email, rol) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador Principal', 'admin@rehobot.com', 'admin');

-- Índices para mejorar rendimiento
CREATE INDEX idx_contactos_fecha ON contactos(fecha_envio);
CREATE INDEX idx_contactos_estado ON contactos(estado);
CREATE INDEX idx_aplicaciones_fecha ON aplicaciones_trabajo(fecha_envio);
CREATE INDEX idx_aplicaciones_estado ON aplicaciones_trabajo(estado);
CREATE INDEX idx_contactos_email ON contactos(email);
CREATE INDEX idx_aplicaciones_email ON aplicaciones_trabajo(email);

-- Índices para tablas de administración
CREATE INDEX idx_admin_sesiones_token ON admin_sesiones(token_sesion);
CREATE INDEX idx_admin_sesiones_usuario ON admin_sesiones(usuario_id);
CREATE INDEX idx_admin_sesiones_activa ON admin_sesiones(activa);
CREATE INDEX idx_admin_logs_usuario ON admin_logs(usuario_id);
CREATE INDEX idx_admin_logs_fecha ON admin_logs(fecha);
