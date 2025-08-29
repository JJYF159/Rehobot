<?php
require_once 'auth.php';

// Script para crear usuarios administradores
// Usar solo desde línea de comandos o eliminar después del uso

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rol = $_POST['rol'] ?? 'operador';
    
    if (empty($usuario) || empty($password) || empty($nombre) || empty($email)) {
        $error = "Todos los campos son requeridos";
    } else {
        $auth = new AuthManager();
        $result = $auth->crearUsuario($usuario, $password, $nombre, $email, $rol);
        
        if ($result['success']) {
            $success = $result['message'];
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario Admin - REHOBOT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        button {
            background: #1E3A8A;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background: #1e40af;
        }
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Crear Usuario Administrador</h1>
        
        <div class="warning">
            <strong>⚠️ ATENCIÓN:</strong> Este archivo debe ser eliminado después de crear los usuarios necesarios por razones de seguridad.
        </div>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                ✅ <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                ❌ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required 
                       value="<?= htmlspecialchars($_POST['usuario'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required minlength="8">
                <small>Mínimo 8 caracteres</small>
            </div>
            
            <div class="form-group">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" required
                       value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol">
                    <option value="operador" <?= ($_POST['rol'] ?? '') === 'operador' ? 'selected' : '' ?>>
                        Operador (Solo lectura)
                    </option>
                    <option value="supervisor" <?= ($_POST['rol'] ?? '') === 'supervisor' ? 'selected' : '' ?>>
                        Supervisor (Lectura y modificación)
                    </option>
                    <option value="admin" <?= ($_POST['rol'] ?? '') === 'admin' ? 'selected' : '' ?>>
                        Administrador (Control total)
                    </option>
                </select>
            </div>
            
            <button type="submit">Crear Usuario</button>
        </form>
        
        <hr style="margin: 2rem 0;">
        
        <h3>📋 Usuarios por Defecto</h3>
        <p><strong>Usuario:</strong> admin<br>
        <strong>Contraseña:</strong> rehobot2025<br>
        <strong>Rol:</strong> Administrador</p>
        
        <p><small><strong>Nota:</strong> Cambiar la contraseña después del primer login.</small></p>
        
        <div style="margin-top: 2rem; text-align: center;">
            <a href="login.html" style="color: #1E3A8A; text-decoration: none;">
                🔑 Ir al Panel de Login
            </a>
        </div>
    </div>
</body>
</html>
