<?php
/**
 * Sistema de envío de emails
 * REHOBOT - Sistema de formularios web
 */

require_once 'config.php';

/**
 * Enviar email de notificación para contacto
 */
function sendContactNotificationEmail($data, $contactId) {
    $subject = "Nuevo mensaje de contacto - REHOBOT";
    
    $body = "
    <html>
    <head>
        <title>Nuevo mensaje de contacto</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background-color: #1E3A8A; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #1E3A8A; }
            .footer { background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Corporación REHOBOT</h2>
            <p>Nuevo mensaje de contacto</p>
        </div>
        
        <div class='content'>
            <p>Se ha recibido un nuevo mensaje a través del formulario de contacto:</p>
            
            <div class='field'>
                <span class='label'>ID de contacto:</span> #{$contactId}
            </div>
            
            <div class='field'>
                <span class='label'>Nombre:</span> {$data['nombre']}
            </div>
            
            <div class='field'>
                <span class='label'>Email:</span> {$data['email']}
            </div>
            
            <div class='field'>
                <span class='label'>Teléfono:</span> {$data['telefono']}
            </div>
            
            <div class='field'>
                <span class='label'>Empresa:</span> " . ($data['empresa'] ?: 'No especificada') . "
            </div>
            
            <div class='field'>
                <span class='label'>Servicio de interés:</span> " . ($data['servicio'] ?: 'No especificado') . "
            </div>
            
            <div class='field'>
                <span class='label'>Mensaje:</span><br>
                " . nl2br(htmlspecialchars($data['mensaje'])) . "
            </div>
            
            <div class='field'>
                <span class='label'>Fecha:</span> " . date('d/m/Y H:i:s') . "
            </div>
            
            <div class='field'>
                <span class='label'>IP:</span> {$data['ip_address']}
            </div>
        </div>
        
        <div class='footer'>
            <p>Este email fue generado automáticamente por el sistema de formularios de REHOBOT</p>
        </div>
    </body>
    </html>
    ";
    
    return sendEmail(EMAIL_CONTACTO, $subject, $body);
}

/**
 * Enviar email de confirmación al cliente (contacto)
 */
function sendContactConfirmationEmail($data) {
    $subject = "Confirmación de mensaje recibido - REHOBOT";
    
    $body = "
    <html>
    <head>
        <title>Mensaje recibido</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background-color: #1E3A8A; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .footer { background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Corporación REHOBOT</h2>
            <p>Gracias por contactarnos</p>
        </div>
        
        <div class='content'>
            <p>Estimado/a {$data['nombre']},</p>
            
            <p>Hemos recibido tu mensaje correctamente. Nuestro equipo lo revisará y se pondrá en contacto contigo en un plazo máximo de 24 horas.</p>
            
            <p><strong>Resumen de tu consulta:</strong></p>
            <p>" . nl2br(htmlspecialchars(substr($data['mensaje'], 0, 200))) . "...</p>
            
            <p>Si tienes alguna consulta urgente, puedes contactarnos directamente:</p>
            <ul>
                <li>Email: contacto@rehobot.com</li>
                <li>Teléfono: +51 xxx xxx xxx</li>
            </ul>
            
            <p>Gracias por confiar en Corporación REHOBOT.</p>
        </div>
        
        <div class='footer'>
            <p>Corporación REHOBOT - Soluciones integrales para el abastecimiento del recurso hídrico</p>
        </div>
    </body>
    </html>
    ";
    
    return sendEmail($data['email'], $subject, $body);
}

/**
 * Enviar email de notificación para aplicación de trabajo
 */
function sendJobApplicationNotificationEmail($data, $cvInfo, $applicationId) {
    $subject = "Nueva aplicación de trabajo - REHOBOT";
    
    $cvText = $cvInfo ? "
    <div class='field'>
        <span class='label'>CV adjunto:</span> {$cvInfo['original_name']} ({$cvInfo['size_kb']} KB)
    </div>" : "
    <div class='field'>
        <span class='label'>CV adjunto:</span> No se adjuntó archivo
    </div>";
    
    $body = "
    <html>
    <head>
        <title>Nueva aplicación de trabajo</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background-color: #1E3A8A; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #1E3A8A; }
            .footer { background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Corporación REHOBOT</h2>
            <p>Nueva aplicación de trabajo</p>
        </div>
        
        <div class='content'>
            <p>Se ha recibido una nueva aplicación de trabajo:</p>
            
            <div class='field'>
                <span class='label'>ID de aplicación:</span> #{$applicationId}
            </div>
            
            <div class='field'>
                <span class='label'>Nombre:</span> {$data['nombre']}
            </div>
            
            <div class='field'>
                <span class='label'>Email:</span> {$data['email']}
            </div>
            
            <div class='field'>
                <span class='label'>Teléfono:</span> {$data['telefono']}
            </div>
            
            <div class='field'>
                <span class='label'>Carrera/Especialidad:</span> {$data['carrera']}
            </div>
            
            <div class='field'>
                <span class='label'>Puesto de interés:</span> {$data['puesto']}
            </div>
            
            $cvText
            
            <div class='field'>
                <span class='label'>Experiencia/Motivación:</span><br>
                " . nl2br(htmlspecialchars($data['experiencia'] ?: 'No especificada')) . "
            </div>
            
            <div class='field'>
                <span class='label'>Fecha:</span> " . date('d/m/Y H:i:s') . "
            </div>
            
            <div class='field'>
                <span class='label'>IP:</span> {$data['ip_address']}
            </div>
        </div>
        
        <div class='footer'>
            <p>Este email fue generado automáticamente por el sistema de formularios de REHOBOT</p>
        </div>
    </body>
    </html>
    ";
    
    return sendEmail(EMAIL_RRHH, $subject, $body);
}

/**
 * Enviar email de confirmación al aplicante
 */
function sendJobApplicationConfirmationEmail($data) {
    $subject = "Confirmación de aplicación recibida - REHOBOT";
    
    $body = "
    <html>
    <head>
        <title>Aplicación recibida</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background-color: #1E3A8A; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .footer { background-color: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Corporación REHOBOT</h2>
            <p>Aplicación recibida</p>
        </div>
        
        <div class='content'>
            <p>Estimado/a {$data['nombre']},</p>
            
            <p>Hemos recibido tu aplicación para el puesto de <strong>{$data['puesto']}</strong>.</p>
            
            <p>Nuestro equipo de Recursos Humanos revisará tu perfil y se pondrá en contacto contigo si tu perfil se ajusta a nuestras necesidades actuales.</p>
            
            <p><strong>Resumen de tu aplicación:</strong></p>
            <ul>
                <li>Puesto: {$data['puesto']}</li>
                <li>Carrera/Especialidad: {$data['carrera']}</li>
                <li>Email: {$data['email']}</li>
                <li>Teléfono: {$data['telefono']}</li>
            </ul>
            
            <p>El proceso de selección puede tomar entre 1 a 3 semanas. Te mantendremos informado sobre el estado de tu aplicación.</p>
            
            <p>Si tienes alguna consulta, puedes contactarnos en:</p>
            <ul>
                <li>Email: rrhh@rehobot.com</li>
                <li>Teléfono: +51 xxx xxx xxx</li>
            </ul>
            
            <p>Gracias por tu interés en formar parte de Corporación REHOBOT.</p>
        </div>
        
        <div class='footer'>
            <p>Corporación REHOBOT - Soluciones integrales para el abastecimiento del recurso hídrico</p>
        </div>
    </body>
    </html>
    ";
    
    return sendEmail($data['email'], $subject, $body);
}

/**
 * Función principal para enviar emails
 */
function sendEmail($to, $subject, $body, $attachments = []) {
    // Headers básicos
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=utf-8',
        'From: Corporación REHOBOT <' . SMTP_USER . '>',
        'Reply-To: ' . EMAIL_CONTACTO,
        'X-Mailer: PHP/' . phpversion()
    ];
    
    try {
        // Usar la función mail() de PHP (básica)
        // Para producción, se recomienda usar PHPMailer o similar
        $success = mail($to, $subject, $body, implode("\r\n", $headers));
        
        if ($success) {
            error_log("Email enviado exitosamente a: $to");
            return true;
        } else {
            error_log("Error enviando email a: $to");
            return false;
        }
        
    } catch (Exception $e) {
        error_log("Excepción enviando email: " . $e->getMessage());
        return false;
    }
}
?>
