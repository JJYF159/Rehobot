// Variables globales
let currentTab = 'contactos';
let currentPage = 1;
let recordsPerPage = 20;
let allData = [];
let filteredData = [];
let currentUser = null;

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Iniciando panel de administración...');
    
    // Verificar si venimos desde un login exitoso (URL parameter)
    const urlParams = new URLSearchParams(window.location.search);
    const fromLogin = urlParams.get('from') === 'login';
    
    if (fromLogin) {
        console.log('✅ Acceso desde login exitoso, iniciando inmediatamente...');
        // Delay más largo para asegurar que las cookies se establecieron
        setTimeout(verificarSesion, 2000);
    } else {
        console.log('🔍 Acceso directo, verificando autenticación...');
        // Delay menor para acceso directo
        setTimeout(verificarSesion, 500);
    }
});

// Verificar sesión cada 5 minutos para mantenerla activa
setInterval(verificarSesion, 300000);

// Configurar manejo de navegación del navegador
function configurarNavegacion() {
    console.log('🧭 Configurando manejo de navegación...');
    
    // Detectar cuando el usuario presiona atrás/adelante
    window.addEventListener('popstate', function(event) {
        console.log('🔄 Navegación detectada');
        
        // Si el usuario navega hacia atrás, cerrar sesión
        console.log('🚪 Navegación hacia atrás detectada, cerrando sesión...');
        logoutYRedirigir();
    });
    
    // Detectar cuando la página se va a descargar
    window.addEventListener('beforeunload', function(event) {
        // Cerrar sesión de forma síncrona si es navegación hacia atrás
        navigator.sendBeacon('../php/logout_cookie.php', new FormData());
    });
}

// Cerrar sesión y redirigir
async function logoutYRedirigir() {
    try {
        console.log('🚪 Cerrando sesión...');
        
        // Cerrar sesión en el servidor
        await fetch('../php/logout_cookie.php', {
            method: 'POST',
            credentials: 'include'
        });
        
        console.log('✅ Sesión cerrada correctamente');
    } catch (error) {
        console.error('Error cerrando sesión:', error);
    } finally {
        // Limpiar estado local
        currentUser = null;
        window.adminAuthorized = false;
        
        // Redirigir al index principal del sitio web
        window.location.href = '../index.html';
    }
}

// Verificar sesión de usuario con múltiples intentos
async function verificarSesion(intentos = 3) {
    for (let intento = 1; intento <= intentos; intento++) {
        try {
            console.log(`🔍 Verificando sesión del usuario... (Intento ${intento}/${intentos})`);
            
            const response = await fetch('../php/verificar_cookie.php', {
                method: 'GET',
                credentials: 'include',
                cache: 'no-cache',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) {
                console.log(`❌ Error HTTP: ${response.status} en intento ${intento}`);
                if (intento === intentos) {
                    throw new Error('Error en la respuesta del servidor');
                }
                await new Promise(resolve => setTimeout(resolve, 1000 * intento));
                continue;
            }
            
            const result = await response.json();
            console.log(`📋 Resultado de verificación (intento ${intento}):`, result);
            
            if (result.loggedIn) {
                console.log(`✅ Sesión válida encontrada en intento ${intento}`);
                currentUser = result.user;
                console.log('✅ Sesión válida para usuario:', currentUser.nombre);
                
                // Configurar navegación solo después de verificar sesión
                configurarNavegacion();
                inicializarAdmin();
                return;
            } else {
                console.log(`❌ Sesión no válida en intento ${intento}`);
                if (intento < intentos) {
                    console.log(`⏱️ Esperando ${1000 * intento}ms antes del siguiente intento...`);
                    await new Promise(resolve => setTimeout(resolve, 1000 * intento));
                }
            }
            
        } catch (error) {
            console.error(`❌ Error en intento ${intento}:`, error);
            if (intento < intentos) {
                console.log(`⏱️ Esperando ${1000 * intento}ms antes del siguiente intento...`);
                await new Promise(resolve => setTimeout(resolve, 1000 * intento));
            }
        }
    }
    
    // Si llegamos aquí, todos los intentos fallaron
    console.log('❌ Todos los intentos de verificación fallaron, redirigiendo al login...');
    
    // Mostrar un mensaje antes de redirigir
    if (document.body) {
        const mensaje = document.createElement('div');
        mensaje.style.cssText = `
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background: #f44336; color: white; padding: 20px; border-radius: 5px;
            z-index: 10000; text-align: center; font-family: Arial, sans-serif;
        `;
        mensaje.innerHTML = `
            <h3>⚠️ Sesión no válida</h3>
            <p>Redirigiendo al login en 3 segundos...</p>
        `;
        document.body.appendChild(mensaje);
    }
    
    setTimeout(() => {
        console.log('🔄 Redirigiendo al login por fallos de verificación...');
        window.location.href = 'login.html';
    }, 3000);
}

// Función para inicializar el admin panel
function inicializarAdmin() {
    console.log('✅ Sesión verificada. Inicializando panel admin...');
    
    // Marcar como autorizado
    window.adminAuthorized = true;
    
    mostrarInfoUsuario();
    loadStats();
    loadData();
    
    // Mostrar notificación de bienvenida
    if (currentUser) {
        console.log(`👋 Bienvenido ${currentUser.nombre} (${currentUser.rol})`);
    }
}

// Mostrar información del usuario logueado
function mostrarInfoUsuario() {
    // La información del usuario ahora se muestra en los botones del header
    // Solo actualizar el texto si es necesario
    console.log('Usuario logueado:', currentUser.nombre, currentUser.rol);
}

// Cerrar sesión
async function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión y volver al sitio web principal?')) {
        console.log('🚪 Usuario solicitó cerrar sesión y volver al index principal');
        logoutYRedirigir();
    }
}

// Cargar estadísticas
async function loadStats() {
    try {
        console.log('🔄 Cargando estadísticas...');
        const response = await fetch('../php/admin_stats.php', {
            credentials: 'same-origin',
            cache: 'no-cache' // Evitar caché para obtener datos actuales
        });
        
        if (!response.ok) {
            throw new Error('Error HTTP: ' + response.status);
        }
        
        const stats = await response.json();
        console.log('📊 Estadísticas recibidas:', stats);
        
        // Verificar si hay información de debug
        if (stats.debug) {
            console.log('🐛 Debug info:', stats.debug);
        }
        
        document.getElementById('stats').innerHTML = `
            <div class="stat-card">
                <h3>Total Contactos</h3>
                <div class="number">${stats.total_contactos || 0}</div>
                <div class="description">Mensajes recibidos</div>
            </div>
            <div class="stat-card">
                <h3>Contactos Nuevos</h3>
                <div class="number">${stats.contactos_nuevos || 0}</div>
                <div class="description">Sin responder</div>
            </div>
            <div class="stat-card">
                <h3>Total Aplicaciones</h3>
                <div class="number">${stats.total_aplicaciones || 0}</div>
                <div class="description">CV recibidos</div>
            </div>
            <div class="stat-card">
                <h3>En Proceso</h3>
                <div class="number">${stats.aplicaciones_proceso || 0}</div>
                <div class="description">En revisión/entrevista</div>
            </div>
        `;
        
        console.log('✅ Estadísticas actualizadas en la interfaz');
    } catch (error) {
        console.error('❌ Error cargando estadísticas:', error);
        document.getElementById('stats').innerHTML = `
            <div class="stat-card">
                <h3>Error</h3>
                <div class="number">⚠️</div>
                <div class="description">No se pudieron cargar las estadísticas</div>
            </div>
        `;
    }
}

// Cambiar pestaña
function switchTab(tab, element) {
    currentTab = tab;
    currentPage = 1;
    
    // Actualizar pestañas activas
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    element.classList.add('active');
    
    // Actualizar filtro de estado
    updateStatusFilter();
    
    // Cargar datos
    loadData();
}

// Actualizar opciones de filtro de estado según la pestaña
function updateStatusFilter() {
    const filterEstado = document.getElementById('filterEstado');
    
    if (currentTab === 'contactos') {
        filterEstado.innerHTML = `
            <option value="">Todos</option>
            <option value="nuevo">Nuevo</option>
            <option value="leido">Leído</option>
            <option value="respondido">Respondido</option>
        `;
    } else {
        filterEstado.innerHTML = `
            <option value="">Todos</option>
            <option value="nuevo">Nuevo</option>
            <option value="revision">En revisión</option>
            <option value="entrevista">Entrevista</option>
            <option value="contratado">Contratado</option>
            <option value="rechazado">Rechazado</option>
        `;
    }
}

// Cargar datos
async function loadData() {
    try {
        const response = await fetch(`../php/admin_data.php?type=${currentTab}`, {
            credentials: 'same-origin'
        });
        
        if (!response.ok) {
            throw new Error('Error HTTP: ' + response.status);
        }
        
        allData = await response.json();
        applyFilters();
    } catch (error) {
        console.error('Error cargando datos:', error);
        document.getElementById('dataTable').innerHTML = '<tr><td colspan="100%">❌ Error cargando datos. Verifique su sesión.</td></tr>';
        
        // Si es un error 401 o 403, puede ser un problema de sesión
        if (error.message.includes('401') || error.message.includes('403')) {
            setTimeout(() => {
                alert('Su sesión ha expirado. Será redirigido al login.');
                window.location.href = 'login.html';
            }, 2000);
        }
    }
}

// Aplicar filtros
function applyFilters() {
    const estado = document.getElementById('filterEstado').value;
    const fechaDesde = document.getElementById('filterFechaDesde').value;
    const fechaHasta = document.getElementById('filterFechaHasta').value;
    const buscar = document.getElementById('filterBuscar').value.toLowerCase();
    
    filteredData = allData.filter(item => {
        // Filtro por estado
        if (estado && item.estado !== estado) return false;
        
        // Filtro por fecha
        const itemDate = new Date(item.fecha_envio).toISOString().split('T')[0];
        if (fechaDesde && itemDate < fechaDesde) return false;
        if (fechaHasta && itemDate > fechaHasta) return false;
        
        // Filtro por búsqueda
        if (buscar) {
            const searchFields = currentTab === 'contactos' 
                ? [item.nombre, item.email, item.empresa, item.mensaje]
                : [item.nombre, item.email, item.carrera, item.puesto];
            
            const found = searchFields.some(field => 
                field && field.toLowerCase().includes(buscar)
            );
            if (!found) return false;
        }
        
        return true;
    });
    
    currentPage = 1;
    renderTable();
    renderPagination();
}

// Renderizar tabla
function renderTable() {
    const table = document.getElementById('dataTable');
    const start = (currentPage - 1) * recordsPerPage;
    const end = start + recordsPerPage;
    const pageData = filteredData.slice(start, end);
    
    if (currentTab === 'contactos') {
        renderContactsTable(table, pageData);
    } else {
        renderJobsTable(table, pageData);
    }
}

// Renderizar tabla de contactos
function renderContactsTable(table, data) {
    table.innerHTML = `
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Empresa</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            ${data.map(item => `
                <tr>
                    <td>#${item.id}</td>
                    <td>${item.nombre}</td>
                    <td><a href="mailto:${item.email}">${item.email}</a></td>
                    <td><a href="tel:${item.telefono}">${item.telefono}</a></td>
                    <td>${item.empresa || '-'}</td>
                    <td class="message-preview" title="${item.mensaje}">${item.mensaje}</td>
                    <td>${formatDate(item.fecha_envio)}</td>
                    <td><span class="status-badge status-${item.estado}">${item.estado}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-primary" onclick="updateStatus(${item.id}, 'contactos')">✏️</button>
                            <button class="btn btn-success" onclick="replyTo('${item.email}')">📧</button>
                            <button class="btn btn-danger" onclick="deleteRecord(${item.id}, 'contactos')">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('')}
        </tbody>
    `;
}

// Renderizar tabla de trabajos
function renderJobsTable(table, data) {
    table.innerHTML = `
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Carrera</th>
                <th>Puesto</th>
                <th>CV</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            ${data.map(item => `
                <tr>
                    <td>#${item.id}</td>
                    <td>${item.nombre}</td>
                    <td><a href="mailto:${item.email}">${item.email}</a></td>
                    <td><a href="tel:${item.telefono}">${item.telefono}</a></td>
                    <td>${item.carrera}</td>
                    <td>${item.puesto}</td>
                    <td>${item.cv_archivo ? `<a href="../uploads/cv/${item.cv_archivo}" class="file-link" target="_blank">📄 Ver CV</a>` : '-'}</td>
                    <td>${formatDate(item.fecha_envio)}</td>
                    <td><span class="status-badge status-${item.estado}">${item.estado}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-primary" onclick="updateStatus(${item.id}, 'trabajos')">✏️</button>
                            <button class="btn btn-success" onclick="replyTo('${item.email}')">📧</button>
                            <button class="btn btn-danger" onclick="deleteRecord(${item.id}, 'trabajos')">🗑️</button>
                        </div>
                    </td>
                </tr>
            `).join('')}
        </tbody>
    `;
}

// Renderizar paginación
function renderPagination() {
    const totalPages = Math.ceil(filteredData.length / recordsPerPage);
    const pagination = document.getElementById('pagination');
    
    let paginationHTML = '';
    
    // Botón anterior
    if (currentPage > 1) {
        paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage - 1})">« Anterior</button>`;
    }
    
    // Números de página
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
            paginationHTML += `<button class="page-btn active">${i}</button>`;
        } else if (i <= 3 || i >= totalPages - 2 || Math.abs(i - currentPage) <= 1) {
            paginationHTML += `<button class="page-btn" onclick="changePage(${i})">${i}</button>`;
        } else if (i === 4 || i === totalPages - 3) {
            paginationHTML += `<span class="page-btn">...</span>`;
        }
    }
    
    // Botón siguiente
    if (currentPage < totalPages) {
        paginationHTML += `<button class="page-btn" onclick="changePage(${currentPage + 1})">Siguiente »</button>`;
    }
    
    pagination.innerHTML = paginationHTML;
}

// Cambiar página
function changePage(page) {
    currentPage = page;
    renderTable();
    renderPagination();
}

// Formatear fecha
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString('es-PE', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Limpiar filtros
function clearFilters() {
    document.getElementById('filterEstado').value = '';
    document.getElementById('filterFechaDesde').value = '';
    document.getElementById('filterFechaHasta').value = '';
    document.getElementById('filterBuscar').value = '';
    applyFilters();
}

// Actualizar estado
function updateStatus(id, type) {
    const newStatus = prompt('Nuevo estado:', '');
    if (!newStatus) return;
    
    console.log(`🔄 Actualizando estado del registro ${id} (${type}) a: ${newStatus}`);
    
    fetch('../php/admin_update.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, type, status: newStatus }),
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(result => {
        console.log('📝 Resultado actualización:', result);
        if (result.success) {
            console.log('✅ Estado actualizado correctamente');
            // Recargar datos y estadísticas
            loadData();
            loadStats();
        } else {
            console.error('❌ Error actualizando estado:', result.message);
            alert('Error actualizando estado: ' + result.message);
        }
    })
    .catch(error => {
        console.error('❌ Error en petición de actualización:', error);
        alert('Error de red al actualizar estado');
    });
}

// Responder email
function replyTo(email) {
    window.open(`mailto:${email}?subject=Re: Contacto REHOBOT`);
}

// Eliminar registro
function deleteRecord(id, type) {
    if (!confirm('¿Estás seguro de eliminar este registro?')) return;
    
    console.log(`🗑️ Eliminando registro ${id} (${type})`);
    
    fetch('../php/admin_delete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, type }),
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(result => {
        console.log('🗑️ Resultado eliminación:', result);
        if (result.success) {
            console.log('✅ Registro eliminado correctamente');
            // Recargar datos y estadísticas inmediatamente
            loadData();
            loadStats();
            
            // También recargar después de un pequeño delay para asegurar que la BD se actualizó
            setTimeout(() => {
                console.log('🔄 Recarga adicional de estadísticas...');
                loadStats();
            }, 1000);
        } else {
            console.error('❌ Error eliminando registro:', result.message);
            alert('Error eliminando registro: ' + result.message);
        }
    })
    .catch(error => {
        console.error('❌ Error en petición de eliminación:', error);
        alert('Error de red al eliminar registro');
    });
}

// Exportar datos
function exportData() {
    const csvContent = generateCSV(filteredData);
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `rehobot_${currentTab}_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Generar CSV
function generateCSV(data) {
    if (data.length === 0) return '';
    
    const headers = Object.keys(data[0]);
    const csvHeaders = headers.join(',');
    const csvRows = data.map(row => 
        headers.map(header => {
            const value = row[header] || '';
            return `"${value.toString().replace(/"/g, '""')}"`;
        }).join(',')
    );
    
    return csvHeaders + '\n' + csvRows.join('\n');
}

// Funciones para cambio de contraseña
async function showChangePasswordModal() {
    // Obtener token CSRF
    try {
        const response = await fetch('../php/get_csrf_token.php');
        const result = await response.json();
        if (result.success) {
            document.getElementById('csrf_token').value = result.token;
        }
    } catch (error) {
        console.error('Error obteniendo token CSRF:', error);
    }
    
    document.getElementById('changePasswordModal').style.display = 'flex';
    document.getElementById('changePasswordForm').reset();
}

function hideChangePasswordModal() {
    document.getElementById('changePasswordModal').style.display = 'none';
    document.getElementById('changePasswordForm').reset();
    updatePasswordStrength('');
}

// Validar fuerza de contraseña
function validatePasswordStrength(password) {
    let strength = 0;
    let feedback = [];
    
    if (password.length >= 8) {
        strength += 25;
    } else {
        feedback.push('al menos 8 caracteres');
    }
    
    if (/[a-z]/.test(password)) {
        strength += 15;
    } else {
        feedback.push('minúsculas');
    }
    
    if (/[A-Z]/.test(password)) {
        strength += 15;
    } else {
        feedback.push('mayúsculas');
    }
    
    if (/[0-9]/.test(password)) {
        strength += 15;
    } else {
        feedback.push('números');
    }
    
    if (/[^A-Za-z0-9]/.test(password)) {
        strength += 15;
    } else {
        feedback.push('símbolos');
    }
    
    // Bonus por longitud
    if (password.length >= 12) strength += 15;
    
    return {
        strength: Math.min(100, strength),
        feedback: feedback,
        isValid: strength >= 60 && password.length >= 8
    };
}

function updatePasswordStrength(password) {
    const result = validatePasswordStrength(password);
    const strengthDiv = document.getElementById('passwordStrength');
    
    if (!password) {
        strengthDiv.innerHTML = '';
        return;
    }
    
    let className, text;
    if (result.strength < 30) {
        className = 'weak';
        text = 'Débil';
    } else if (result.strength < 60) {
        className = 'fair';
        text = 'Regular';
    } else if (result.strength < 80) {
        className = 'good';
        text = 'Buena';
    } else {
        className = 'strong';
        text = 'Fuerte';
    }
    
    strengthDiv.innerHTML = `
        <div class="password-strength-bar strength-${className}"></div>
        <div class="password-strength-text text-${className}">
            ${text} (${result.strength}%)
            ${result.feedback.length > 0 ? '<br>Falta: ' + result.feedback.join(', ') : ''}
        </div>
    `;
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('click', function(event) {
    const modal = document.getElementById('changePasswordModal');
    if (event.target === modal) {
        hideChangePasswordModal();
    }
});

// Manejar envío del formulario de cambio de contraseña
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('changePasswordForm');
    const newPasswordInput = document.getElementById('newPassword');
    
    // Validar contraseña en tiempo real
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            updatePasswordStrength(this.value);
        });
    }
    
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const newPassword = formData.get('newPassword');
            const confirmPassword = formData.get('confirmPassword');
            
            // Validar que las contraseñas coincidan
            if (newPassword !== confirmPassword) {
                alert('Las contraseñas no coinciden');
                return;
            }
            
            // Validar fuerza de contraseña
            const passwordValidation = validatePasswordStrength(newPassword);
            if (!passwordValidation.isValid) {
                alert('La contraseña no cumple los requisitos de seguridad');
                return;
            }
            
            // Deshabilitar botón
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Cambiando...';
            
            try {
                const response = await fetch('../php/change_password.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Contraseña cambiada exitosamente');
                    hideChangePasswordModal();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al cambiar la contraseña');
            } finally {
                // Rehabilitar botón
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }
});
