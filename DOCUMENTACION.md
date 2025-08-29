# 🚀 REHOBOT - Sistema Web Completo

## 📝 Descripción General
Sistema web integral para **Corporación REHOBOT** - empresa especializada en perforación de pozos, instalaciones electromecánicas y servicios hidráulicos. Incluye sitio web institucional completo, sistema de formularios con base de datos MySQL, panel de administración avanzado con autenticación y gestión de contenido.

## ✨ Características Principales

### 🌐 Sitio Web Institucional
- ✅ **Landing page** con carrusel de servicios
- ✅ **Página de servicios** detallada con 4 especialidades
- ✅ **Catálogo de productos** con categorías (Electrobombas, Hidráulicos, Eléctricos)
- ✅ **Portafolio de proyectos** con casos de éxito
- ✅ **Página sobre nosotros** con valores corporativos
- ✅ **Páginas de políticas** (Privacidad y Calidad)
- ✅ **Diseño responsive** para móviles y tablets
- ✅ **Optimización SEO** básica
- ✅ **Integración Cloudinary** para imágenes optimizadas

### 📋 Sistema de Formularios
- ✅ **Formulario de contacto** con validaciones avanzadas
- ✅ **Formulario de aplicaciones laborales** con carga de CV
- ✅ **Validación en tiempo real** JavaScript
- ✅ **Protección CSRF** y rate limiting
- ✅ **Envío de emails** automático
- ✅ **Almacenamiento en base de datos** MySQL

### 🔐 Panel de Administración
- ✅ **Sistema de autenticación** seguro con roles
- ✅ **Dashboard con estadísticas** en tiempo real
- ✅ **Gestión de contactos y aplicaciones**
- ✅ **Filtros avanzados** por fecha, estado, búsqueda
- ✅ **Exportación CSV** de datos
- ✅ **Logs de actividad** administrativa
- ✅ **Gestión de usuarios** con roles diferenciados

### 🔒 Seguridad Avanzada
- ✅ **Sistema SecurityManager** con cifrado AES-256-CBC
- ✅ **Autenticación multiroles** (Admin, Supervisor, Operador)
- ✅ **Tokens de sesión** únicos y seguros
- ✅ **Rate limiting** para prevenir spam
- ✅ **Sanitización** de datos de entrada
- ✅ **Protección XSS y SQL Injection**
- ✅ **Headers de seguridad** HTTP

## 🗂️ Estructura del Proyecto

### 📄 Páginas Principales
```
├── index.html                    # Landing page con carrusel hero
├── Nosotros.html                 # Sobre la empresa y valores
├── servicios.html                # Servicios principales
├── productos.html                # Catálogo con pestañas
├── Portafolio.html               # Casos de éxito por categorías
├── contacto.html                 # Formulario de contacto
├── trabaja-con-nosotros.html     # Formulario laboral
├── politica-privacidad.html      # Política de privacidad
├── politica-calidad.html         # Política de calidad
└── [proyecto].html               # Páginas específicas de proyectos
```

### 🎨 Recursos de Diseño
```
├── css/
│   ├── index.css                 # Estilos principales y hero
│   ├── nosotros.css              # Estilos página nosotros
│   ├── servicios.css             # Estilos servicios
│   ├── productos.css             # Estilos catálogo productos
│   ├── Portafolio.css            # Estilos portafolio
│   ├── contacto.css              # Estilos formulario contacto
│   ├── trabaja-con-nosotros.css  # Estilos formulario trabajo
│   ├── politica-privacidad.css   # Estilos políticas
│   ├── proyectos.css             # Estilos páginas proyecto
│   └── styles.css                # Estilos generales
├── js/
│   ├── script.js                 # Scripts generales y navegación
│   └── formularios.js            # Validación y envío formularios
├── svg/                          # Iconos y logos SVG
├── img/                          # Imágenes del sitio
├── logos/                        # Logos de clientes
└── fonts/                        # Fuentes personalizadas
```

### ⚙️ Backend y Base de Datos
```
├── php/
│   ├── config.php                # Configuración principal
│   ├── auth.php                  # Sistema de autenticación
│   ├── login.php                 # Procesamiento de login
│   ├── logout.php                # Cerrar sesión
│   ├── verificar_sesion.php      # Verificar sesión activa
│   ├── procesar_contacto.php     # Procesa formulario contacto
│   ├── procesar_trabajo.php      # Procesa formulario trabajo
│   ├── email.php                 # Sistema de emails
│   ├── admin_stats.php           # API estadísticas
│   ├── admin_data.php            # API datos
│   ├── admin_update.php          # API actualizar
│   └── admin_delete.php          # API eliminar
├── admin/
│   ├── login.html                # Página de login admin
│   ├── index.html                # Dashboard principal
│   ├── admin.css                 # Estilos del admin
│   ├── admin.js                  # Lógica del admin
│   ├── login.css                 # Estilos login
│   ├── login.js                  # Scripts login
│   └── crear_usuario.php         # Utilidad crear usuarios
├── database/
│   └── database.sql              # Estructura completa BD
└── uploads/cv/                   # Archivos CV subidos
```

## 🛠️ Instalación y Configuración

### 1. Requisitos del Sistema
- **PHP 8.0+** con extensiones PDO, OpenSSL, cURL
- **MySQL 5.7+** o MariaDB 10.2+
- **Apache 2.4+** con mod_rewrite habilitado
- **Servidor SMTP** para envío de emails

### 2. Configuración del Entorno

#### Instalar PHP (Windows con Scoop)
```powershell
# Instalar Scoop si no está instalado
Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
iwr -useb get.scoop.sh | iex

# Instalar PHP
scoop install php
php --version  # Verificar instalación
```

#### Configurar Base de Datos
```sql
-- 1. Crear base de datos
CREATE DATABASE rehobot_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Crear usuario específico
CREATE USER 'rehobot_user'@'localhost' IDENTIFIED BY 'password_seguro';
GRANT ALL PRIVILEGES ON rehobot_db.* TO 'rehobot_user'@'localhost';
FLUSH PRIVILEGES;

-- 3. Importar estructura
mysql -u rehobot_user -p rehobot_db < database/database.sql
```

### 3. Configuración de Archivos

#### Configurar `php/config.php`
```php
<?php
// Base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'rehobot_db');
define('DB_USER', 'rehobot_user');
define('DB_PASS', 'tu_password_mysql');

// Email SMTP
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu_email@gmail.com');
define('SMTP_PASS', 'tu_app_password');
define('EMAIL_CONTACTO', 'contacto@rehobot.com');
define('EMAIL_RRHH', 'rrhh@rehobot.com');

// Seguridad
define('ENCRYPTION_KEY', 'tu_clave_256_bits_aqui');
define('SITE_URL', 'https://tudominio.com');

// Configuración de archivos
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['pdf', 'doc', 'docx']);
?>
```

## 🎯 Uso del Sistema

### Sitio Web Público

#### Navegación Principal
- **Nosotros**: Historia, misión, visión y valores de la empresa
- **Servicios**: 4 servicios principales con páginas detalladas
- **Productos**: Catálogo organizado en 3 categorías con pestañas
- **Portafolio**: Proyectos exitosos organizados por tipo
- **Contacto**: Formulario de contacto con validación

#### Características Especiales
- **Carrusel Hero**: 5 slides con diferentes servicios
- **Carrusel de Clientes**: 13 logos con scroll infinito optimizado
- **Navegación Responsive**: Menú hamburguesa en móviles
- **Integración Cloudinary**: Imágenes optimizadas para web

### Panel de Administración

#### Acceso al Sistema
- **URL**: `/admin/login.html`
- **Usuario por defecto**: `admin`
- **Contraseña por defecto**: `rehobot2025`

#### Roles de Usuario
1. **Administrador**: Control total del sistema
2. **Supervisor**: Lectura y modificación de datos
3. **Operador**: Solo lectura de datos

#### Funcionalidades del Dashboard
- **Estadísticas en tiempo real**: Contadores y gráficos
- **Gestión de contactos**: Ver, filtrar, actualizar estados
- **Gestión de aplicaciones**: Revisar CVs, cambiar estados
- **Exportación de datos**: CSV con filtros aplicados
- **Logs de actividad**: Registro de acciones administrativas
- **Gestión de usuarios**: Crear, editar, eliminar administradores

### Integración con Cloudinary

#### Configuración Actual
```javascript
// URLs base para imágenes optimizadas
const CLOUDINARY_BASE = 'https://res.cloudinary.com/dg7wvqxcv/image/upload/';

// Ejemplos implementados:
// Hero background: v1755761554/IMG_BG_n2kjcr.jpg
// Logos clientes: v1755763006/YASISA-LOGO_lu66ww.png
// Productos específicos: v1755761553/Presostato_para_agua_y_aire_p9itsv.jpg
```

#### Beneficios Implementados
- **Optimización automática**: Compresión y formatos modernos
- **CDN global**: Carga rápida desde cualquier ubicación
- **Responsive images**: Diferentes tamaños según dispositivo
- **Transformaciones**: Redimensionado automático

## 📊 Base de Datos

### Esquema Principal
```sql
-- Tabla de contactos
CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    empresa VARCHAR(100),
    servicio VARCHAR(50),
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('nuevo', 'leido', 'respondido', 'cerrado') DEFAULT 'nuevo',
    ip_address VARCHAR(45),
    user_agent TEXT,
    INDEX idx_fecha_envio (fecha_envio),
    INDEX idx_estado (estado),
    INDEX idx_email (email)
);

-- Tabla de aplicaciones de trabajo
CREATE TABLE aplicaciones_trabajo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    carrera VARCHAR(100),
    puesto VARCHAR(100),
    experiencia TEXT,
    cv_archivo VARCHAR(255),
    cv_nombre_original VARCHAR(255),
    cv_tamaño_kb INT,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('nuevo', 'revision', 'entrevista', 'rechazado', 'contratado') DEFAULT 'nuevo',
    ip_address VARCHAR(45),
    user_agent TEXT,
    INDEX idx_fecha_envio (fecha_envio),
    INDEX idx_estado (estado),
    INDEX idx_puesto (puesto)
);

-- Tabla de usuarios administrativos
CREATE TABLE admin_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    rol ENUM('admin', 'supervisor', 'operador') NOT NULL,
    ultimo_acceso TIMESTAMP NULL,
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_usuario (usuario),
    INDEX idx_rol (rol)
);

-- Tabla de sesiones
CREATE TABLE admin_sesiones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP NOT NULL,
    activa TINYINT(1) DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES admin_usuarios(id) ON DELETE CASCADE,
    INDEX idx_token (token),
    INDEX idx_usuario_id (usuario_id),
    INDEX idx_fecha_expiracion (fecha_expiracion)
);
```

## 🎨 Diseño y UX

### Paleta de Colores
```css
:root {
    --color-primario: #0C2A6C;      /* Azul corporativo */
    --color-secundario: #1B8FD6;    /* Azul claro */
    --blanco: #FFFFFF;
    --gris-claro: #F8F9FA;
    --gris: #6C757D;
    --azul-claro: #E8F4F8;
    --azul-desactivado: #A1B0D0;
    --azul-texto: #0C2A6C;
    --blanco-opaco: #D9D9D9;
    --color-footer: #5074C5;
}
```

### Componentes Implementados
1. **Carrusel de logos optimizado**: 13 logos duplicados para scroll infinito
2. **Navegación responsive**: Menú hamburguesa funcional
3. **Formularios validados**: JavaScript en tiempo real
4. **Tarjetas de productos**: Sistema de pestañas
5. **Grid de valores**: Layout 3x2 horizontal

### Tipografía
- **Principal**: Lexend (Variable font weight 100-900)
- **Decorativa**: Pink Sunset (Títulos especiales)
- **Fallback**: Arial, sans-serif

## 🔐 Seguridad Detallada

### Sistema SecurityManager
```php
class SecurityManager {
    // Cifrado AES-256-CBC implementado
    public static function encrypt($data, $key)
    public static function decrypt($data, $key)
    
    // Gestión de tokens implementada
    public static function generateSecureToken($length = 32)
    public static function hashPassword($password)
    public static function verifyPassword($password, $hash)
    
    // Validación y sanitización activa
    public static function sanitizeInput($data)
    public static function validateEmail($email)
    public static function validatePhone($phone)
    
    // Rate limiting funcional
    public static function checkRateLimit($ip, $action, $limit_hours = 1)
}
```

### Medidas de Protección Activas
1. **Autenticación**: Passwords hasheados con bcrypt
2. **Autorización**: Sistema de roles granular
3. **Validación**: Sanitización completa de entrada
4. **Protección**: CSRF, rate limiting, consultas preparadas

## 📧 Sistema de Emails

### Configuración SMTP Activa
- **Proveedor**: Configurable (Gmail, Outlook, cPanel)
- **Plantillas**: HTML profesionales implementadas
- **Adjuntos**: Soporte para CVs en formularios
- **Logging**: Registro de envíos y errores

## 🚀 Características Recientes Implementadas

### Carrusel de Logos Optimizado
- **Problema resuelto**: Reinicio visible al agregar más logos
- **Solución**: Duplicado de contenido para scroll infinito
- **Configuración**: 26 elementos (13 originales + 13 duplicados)
- **CSS**: Anchura fija (260px por logo) y animación 40s

### Integración Cloudinary Completa
- **Hero section**: Imagen de fondo optimizada
- **Logos de clientes**: 13 logos empresariales
- **Productos específicos**: Imágenes categorizadas
- **Performance**: CDN global y compresión automática

### Sistema de Pestañas en Productos
- **Categorías**: Electrobombas, Hidráulicos, Eléctricos
- **Imágenes específicas**: CSS class-based para personalización
- **Responsive**: Funcional en todos los dispositivos

## 🔧 Mantenimiento y Troubleshooting

### Problemas Comunes Resueltos

#### 1. Carrusel que se Reinicia
```css
/* Solución implementada */
.logos-clientes {
    width: calc(26 * 260px);  /* 13 logos x2 duplicados */
    animation: scroll-infinito 40s linear infinite;
}

@keyframes scroll-infinito {
    0% { transform: translateX(0); }
    100% { transform: translateX(calc(-13 * 260px)); }
}
```

#### 2. Imágenes Específicas en Productos
```html
<!-- Estructura implementada -->
<div class="producto-imagen presostato-imagen"></div>

<!-- CSS correspondiente -->
.presostato-imagen {
    background-image: url('https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755761553/Presostato_para_agua_y_aire_p9itsv.jpg');
}
```

### Scripts de Monitoreo
```bash
# Backup automático implementado
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u rehobot_user -p rehobot_db > backups/rehobot_$DATE.sql
gzip backups/rehobot_$DATE.sql
```

## 📞 Soporte y Contacto

### Documentación Técnica
- **Este archivo**: Documentación completa actualizada
- **Código comentado**: Inline documentation en PHP/JS
- **Base de datos**: Schema y queries documentadas

### Contacto para Soporte
- **Email técnico**: dev@rehobot.com
- **Empresa**: Corporación REHOBOT
- **Teléfono**: (51) 989 011 132
- **Sitio web**: https://www.corporacionrehobot.com

---

## 📋 Estado Actual del Proyecto

### ✅ Completado
- [x] Sitio web institucional completo
- [x] Sistema de formularios funcional
- [x] Panel de administración con autenticación
- [x] Base de datos MySQL optimizada
- [x] Integración Cloudinary para imágenes
- [x] Carrusel de logos corregido
- [x] Diseño responsive en todas las páginas
- [x] Sistema de seguridad robusto
- [x] Páginas de políticas empresariales
- [x] Catálogo de productos con pestañas

### 🔄 En Desarrollo
- [ ] Optimización SEO avanzada
- [ ] PWA (Progressive Web App)
- [ ] Sistema de notificaciones push
- [ ] API REST completa

### 🎯 Próximas Mejoras
- [ ] Multi-idioma (Español/Inglés)
- [ ] Chat bot básico
- [ ] Integración con CRM
- [ ] Analytics avanzados
- [ ] Sistema de cotizaciones online

---

**Corporación REHOBOT** - Sistema Web Completo v2.0  
Desarrollado con 💙 para una experiencia web integral y profesional.

*Última actualización: Agosto 2025*
*Estado: Producción completa con todas las funcionalidades operativas*
