
// Variables globales
let csrfToken = '';

// Inicializar cuando carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Generar token CSRF
    generateCSRFToken();
    
    // Configurar formulario de contacto
    const contactForm = document.getElementById('formularioContacto');
    if (contactForm) {
        setupContactForm(contactForm);
    }
    
    // Configurar formulario de trabajo
    const jobForm = document.getElementById('formularioTrabajo');
    if (jobForm) {
        setupJobForm(jobForm);
    }
});

/**
 * Generar token CSRF
 */
function generateCSRFToken() {
    csrfToken = generateRandomToken();
    
    // Asignar a todos los campos ocultos de CSRF
    const csrfInputs = document.querySelectorAll('input[name="csrf_token"]');
    csrfInputs.forEach(input => {
        input.value = csrfToken;
    });
}

/**
 * Generar token aleatorio
 */
function generateRandomToken() {
    const array = new Uint8Array(32);
    crypto.getRandomValues(array);
    return Array.from(array, byte => byte.toString(16).padStart(2, '0')).join('');
}

/**
 * Configurar formulario de contacto
 */
function setupContactForm(form) {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = form.querySelector('.btn-enviar');
        const btnTexto = submitBtn.querySelector('.btn-texto');
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        // Validar formulario
        if (!validateContactForm(form)) {
            return;
        }
        
        // Mostrar estado de carga
        setLoadingState(submitBtn, btnTexto, btnLoading, true);
        
        try {
            // Recopilar datos del formulario
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            data.csrf_token = csrfToken;
            
            // Enviar formulario
            const response = await fetch('php/procesar_contacto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                showSuccessMessage('¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.');
                form.reset();
                generateCSRFToken(); // Generar nuevo token
            } else {
                showErrorMessage(result.message || 'Error enviando el mensaje. Por favor intenta de nuevo.');
            }
            
        } catch (error) {
            console.error('Error:', error);
            showErrorMessage('Error de conexión. Por favor verifica tu conexión a internet e intenta de nuevo.');
        } finally {
            // Quitar estado de carga
            setLoadingState(submitBtn, btnTexto, btnLoading, false);
        }
    });
}

/**
 * Configurar formulario de trabajo
 */
function setupJobForm(form) {
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = form.querySelector('.btn-enviar');
        const btnTexto = submitBtn.querySelector('.btn-texto') || submitBtn;
        const btnLoading = submitBtn.querySelector('.btn-loading');
        
        // Validar formulario
        if (!validateJobForm(form)) {
            return;
        }
        
        // Mostrar estado de carga
        setLoadingState(submitBtn, btnTexto, btnLoading, true);
        
        try {
            // Recopilar datos del formulario (incluyendo archivo)
            const formData = new FormData(form);
            formData.append('csrf_token', csrfToken);
            
            // Enviar formulario
            const response = await fetch('php/procesar_trabajo.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showSuccessMessage('¡Aplicación enviada correctamente! Revisaremos tu perfil y nos pondremos en contacto contigo.');
                form.reset();
                resetFileInput(form);
                generateCSRFToken(); // Generar nuevo token
            } else {
                showErrorMessage(result.message || 'Error enviando la aplicación. Por favor intenta de nuevo.');
            }
            
        } catch (error) {
            console.error('Error:', error);
            showErrorMessage('Error de conexión. Por favor verifica tu conexión a internet e intenta de nuevo.');
        } finally {
            // Quitar estado de carga
            setLoadingState(submitBtn, btnTexto, btnLoading, false);
        }
    });
    
    // Configurar preview del archivo CV
    const fileInput = form.querySelector('input[type="file"]');
    if (fileInput) {
        setupFilePreview(fileInput);
    }
}

/**
 * Validar formulario de contacto
 */
function validateContactForm(form) {
    const requiredFields = ['nombre', 'email', 'telefono', 'ciudad', 'mensaje'];
    let isValid = true;
    
    // Limpiar errores previos
    clearFieldErrors(form);
    
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field || !field.value.trim()) {
            showFieldError(field, 'Este campo es requerido');
            isValid = false;
        }
    });
    
    // Validar email específicamente
    const emailField = form.querySelector('[name="email"]');
    if (emailField && emailField.value && !isValidEmail(emailField.value)) {
        showFieldError(emailField, 'Email inválido');
        isValid = false;
    }
    
    // Validar longitud de mensaje
    const messageField = form.querySelector('[name="mensaje"]');
    if (messageField && messageField.value.length > 5000) {
        showFieldError(messageField, 'El mensaje es demasiado largo (máximo 5000 caracteres)');
        isValid = false;
    }
    
    return isValid;
}

/**
 * Validar formulario de trabajo
 */
function validateJobForm(form) {
    const requiredFields = ['nombre', 'email', 'telefono', 'carrera', 'puesto'];
    let isValid = true;
    
    // Limpiar errores previos
    clearFieldErrors(form);
    
    requiredFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (!field || !field.value.trim()) {
            showFieldError(field, 'Este campo es requerido');
            isValid = false;
        }
    });
    
    // Validar email específicamente
    const emailField = form.querySelector('[name="email"]');
    if (emailField && emailField.value && !isValidEmail(emailField.value)) {
        showFieldError(emailField, 'Email inválido');
        isValid = false;
    }
    
    // Validar archivo CV
    const fileField = form.querySelector('[name="cv"]');
    if (fileField && fileField.files[0]) {
        const file = fileField.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        if (file.size > maxSize) {
            showFieldError(fileField, 'El archivo es demasiado grande (máximo 5MB)');
            isValid = false;
        }
        
        if (!allowedTypes.includes(file.type)) {
            showFieldError(fileField, 'Formato de archivo no válido (solo PDF, DOC, DOCX)');
            isValid = false;
        }
    }
    
    return isValid;
}

/**
 * Configurar preview de archivo
 */
function setupFilePreview(fileInput) {
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const label = fileInput.closest('.archivo-input').querySelector('.archivo-texto');
        
        if (file) {
            const fileName = file.name.length > 30 ? file.name.substring(0, 30) + '...' : file.name;
            const fileSize = (file.size / 1024).toFixed(1);
            label.textContent = `${fileName} (${fileSize} KB)`;
            label.style.color = '#10B981'; // Verde para archivo seleccionado
        } else {
            label.textContent = 'Adjuntar archivo*';
            label.style.color = '';
        }
    });
}

/**
 * Resetear input de archivo
 */
function resetFileInput(form) {
    const fileInput = form.querySelector('input[type="file"]');
    if (fileInput) {
        const label = fileInput.closest('.archivo-input').querySelector('.archivo-texto');
        label.textContent = 'Adjuntar archivo*';
        label.style.color = '';
    }
}

/**
 * Establecer estado de carga del botón
 */
function setLoadingState(button, textElement, loadingElement, isLoading) {
    if (isLoading) {
        button.disabled = true;
        button.classList.add('loading');
        if (textElement) textElement.style.display = 'none';
        if (loadingElement) loadingElement.style.display = 'inline';
    } else {
        button.disabled = false;
        button.classList.remove('loading');
        if (textElement) textElement.style.display = 'inline';
        if (loadingElement) loadingElement.style.display = 'none';
    }
}

/**
 * Mostrar mensaje de éxito
 */
function showSuccessMessage(message) {
    // Crear notificación
    const notification = createNotification(message, 'success');
    document.body.appendChild(notification);
    
    // Auto-eliminar después de 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

/**
 * Mostrar mensaje de error
 */
function showErrorMessage(message) {
    // Crear notificación
    const notification = createNotification(message, 'error');
    document.body.appendChild(notification);
    
    // Auto-eliminar después de 7 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 7000);
}

/**
 * Crear elemento de notificación
 */
function createNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-icon">${type === 'success' ? '✓' : '⚠'}</span>
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentNode.parentNode.remove()">×</button>
        </div>
    `;
    
    // Estilos inline para la notificación
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        background: ${type === 'success' ? '#10B981' : '#EF4444'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        max-width: 400px;
        animation: slideInRight 0.3s ease-out;
    `;
    
    return notification;
}

/**
 * Mostrar error en campo específico
 */
function showFieldError(field, message) {
    if (!field) return;
    
    // Añadir clase de error
    field.classList.add('field-error');
    
    // Crear mensaje de error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error-message';
    errorDiv.textContent = message;
    errorDiv.style.cssText = 'color: #EF4444; font-size: 0.875rem; margin-top: 0.25rem;';
    
    // Insertar mensaje después del campo
    field.parentNode.appendChild(errorDiv);
}

/**
 * Limpiar errores de campos
 */
function clearFieldErrors(form) {
    // Remover clases de error
    const errorFields = form.querySelectorAll('.field-error');
    errorFields.forEach(field => field.classList.remove('field-error'));
    
    // Remover mensajes de error
    const errorMessages = form.querySelectorAll('.field-error-message');
    errorMessages.forEach(msg => msg.remove());
}

/**
 * Validar email
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Estilos CSS adicionales para notificaciones
const notificationStyles = document.createElement('style');
notificationStyles.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .notification-icon {
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .notification-close {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        margin-left: auto;
        padding: 0;
        line-height: 1;
    }
    
    .notification-close:hover {
        opacity: 0.8;
    }
    
    .field-error {
        border-color: #EF4444 !important;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
    }
`;

document.head.appendChild(notificationStyles);
