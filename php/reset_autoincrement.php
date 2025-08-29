<?php
/**
 * Script para reiniciar autoincrements manualmente
 */

require_once 'config.php';
require_once 'auth.php';

// Solo permitir acceso si está autenticado
$auth = new AuthManager();
$sesion = $auth->verificarSesion();

if (!$sesion) {
    die('❌ Acceso denegado. Debes estar autenticado.');
}

try {
    $db = Database::getInstance();
    
    echo "<h1>🔧 Herramienta de Mantenimiento - Autoincrements</h1>";
    echo "<p>Usuario: " . $sesion['nombre'] . " (" . $sesion['rol'] . ")</p>";
    echo "<p>Fecha/Hora: " . date('Y-m-d H:i:s') . "</p>";
    
    // Verificar estado actual
    echo "<h2>📊 Estado Actual</h2>";
    
    // Contactos
    $countContactos = $db->fetchOne("SELECT COUNT(*) as total FROM contactos")['total'];
    $infoContactos = $db->fetchOne("SHOW TABLE STATUS LIKE 'contactos'");
    $nextIdContactos = $infoContactos['Auto_increment'];
    echo "Contactos: {$countContactos} registros, próximo ID: {$nextIdContactos}<br>";
    
    // Aplicaciones
    $countAplicaciones = $db->fetchOne("SELECT COUNT(*) as total FROM aplicaciones_trabajo")['total'];
    $infoAplicaciones = $db->fetchOne("SHOW TABLE STATUS LIKE 'aplicaciones_trabajo'");
    $nextIdAplicaciones = $infoAplicaciones['Auto_increment'];
    echo "Aplicaciones: {$countAplicaciones} registros, próximo ID: {$nextIdAplicaciones}<br>";
    
    // Acciones disponibles
    echo "<h2>🛠️ Acciones Disponibles</h2>";
    
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        
        if ($action === 'reset_contactos' && $countContactos == 0) {
            $db->query("ALTER TABLE contactos AUTO_INCREMENT = 1");
            echo "✅ Autoincrement de contactos reiniciado a 1<br>";
            
        } elseif ($action === 'reset_aplicaciones' && $countAplicaciones == 0) {
            $db->query("ALTER TABLE aplicaciones_trabajo AUTO_INCREMENT = 1");
            echo "✅ Autoincrement de aplicaciones reiniciado a 1<br>";
            
        } elseif ($action === 'reset_contactos' && $countContactos > 0) {
            echo "⚠️ No se puede reiniciar: hay {$countContactos} registros en contactos<br>";
            
        } elseif ($action === 'reset_aplicaciones' && $countAplicaciones > 0) {
            echo "⚠️ No se puede reiniciar: hay {$countAplicaciones} registros en aplicaciones<br>";
            
        } else {
            echo "❌ Acción no válida<br>";
        }
        
        echo "<br><a href='?'>🔄 Actualizar estado</a><br>";
    }
    
    // Mostrar botones solo si se puede resetear
    if ($countContactos == 0) {
        echo "<a href='?action=reset_contactos' onclick='return confirm(\"¿Reiniciar autoincrement de contactos?\")'>🔧 Reiniciar Contactos</a><br>";
    } else {
        echo "🚫 No se puede reiniciar contactos (hay {$countContactos} registros)<br>";
    }
    
    if ($countAplicaciones == 0) {
        echo "<a href='?action=reset_aplicaciones' onclick='return confirm(\"¿Reiniciar autoincrement de aplicaciones?\")'>🔧 Reiniciar Aplicaciones</a><br>";
    } else {
        echo "🚫 No se puede reiniciar aplicaciones (hay {$countAplicaciones} registros)<br>";
    }
    
    echo "<br><h3>📝 Nota:</h3>";
    echo "Solo se puede reiniciar el autoincrement cuando no hay registros en la tabla.<br>";
    echo "Para reiniciar completamente, elimina todos los registros primero.<br>";
    
} catch (Exception $e) {
    echo "<h1>❌ Error</h1>";
    echo "Error: " . $e->getMessage();
}
?>
