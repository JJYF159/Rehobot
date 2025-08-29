// Función para inicializar desplegables
function initializeDropdown() {
    // Buscar todos los elementos necesarios
    const enlaceServicios = document.querySelector('a[href="servicios.html"]');
    const desplegable = document.querySelector('.contenido-desplegable');
    const encabezado = document.querySelector('.encabezado');
    const flecha = enlaceServicios ? enlaceServicios.querySelector('.flecha') : null;
    
    if (!enlaceServicios || !desplegable || !encabezado) {
        console.error('FALTAN ELEMENTOS CRÍTICOS');
        return;
    }
    
    let timeoutId = null;
    let isHoveringServiceArea = false;
    
    function mostrarDesplegable() {
        if (timeoutId) {
            clearTimeout(timeoutId);
            timeoutId = null;
        }
        
        isHoveringServiceArea = true;
        desplegable.style.display = 'flex';
        desplegable.style.opacity = '1';
        desplegable.classList.add('activo');
        
        if (flecha) {
            flecha.classList.add('activa');
        }
        
        const todosLosEnlaces = document.querySelectorAll('.enlaces-izquierda a, .enlaces-derecha a');
        todosLosEnlaces.forEach(enlace => {
            if (enlace !== enlaceServicios) {
                enlace.classList.add('desactivado');
            }
        });
    }
    
    function programarOcultacion() {
        timeoutId = setTimeout(() => {
            if (!isHoveringServiceArea) {
                desplegable.style.opacity = '0';
                desplegable.classList.remove('activo');
                setTimeout(() => {
                    desplegable.style.display = 'none';
                }, 300);
                
                if (flecha) {
                    flecha.classList.remove('activa');
                }
                
                const todosLosEnlaces = document.querySelectorAll('.enlaces-izquierda a, .enlaces-derecha a');
                todosLosEnlaces.forEach(enlace => {
                    enlace.classList.remove('desactivado');
                });
            }
        }, 300); // Tiempo más largo para permitir el movimiento del mouse
    }
    
    // Eventos para el enlace Servicios
    enlaceServicios.addEventListener('mouseenter', mostrarDesplegable);
    enlaceServicios.addEventListener('mouseleave', () => {
        isHoveringServiceArea = false;
        programarOcultacion();
    });
    
    // Eventos para el contenido desplegable
    desplegable.addEventListener('mouseenter', () => {
        isHoveringServiceArea = true;
        mostrarDesplegable();
    });
    
    desplegable.addEventListener('mouseleave', () => {
        isHoveringServiceArea = false;
        programarOcultacion();
    });
    
    // Manejar clicks en el enlace de servicios
    enlaceServicios.addEventListener('click', (e) => {
        // Si el desplegable está visible y activo, permitir la navegación
        // Si no está visible, mostrar el desplegable y prevenir la navegación
        if (!desplegable.classList.contains('activo')) {
            e.preventDefault();
            mostrarDesplegable();
        }
        // Si ya está activo, permitir que el click navegue normalmente a servicios.html
    });
    
    // Cerrar cuando se hace clic en cualquier parte fuera del área
    document.addEventListener('click', (e) => {
        if (!enlaceServicios.contains(e.target) && !desplegable.contains(e.target)) {
            isHoveringServiceArea = false;
            programarOcultacion();
        }
    });
}

// Función para inicializar el slider automático
function initializeSlider() {
    const slides = document.querySelectorAll('.slide');
    const indicadores = document.querySelectorAll('.indicador');
    let currentSlide = 0;
    let sliderInterval;
    
    if (slides.length === 0 || indicadores.length === 0) {
        console.error('No se encontraron slides o indicadores');
        return;
    }
    
    // Verificar si ya está inicializado
    if (window.sliderInitialized) {
        console.log('Slider ya está inicializado');
        return;
    }
    window.sliderInitialized = true;
    
    // Función para cambiar slide
    function changeSlide(slideIndex) {
        console.log('Cambiando de slide', currentSlide, 'a', slideIndex);
        
        // Remover clase activa de slide y indicador actual
        slides[currentSlide].classList.remove('active');
        indicadores[currentSlide].classList.remove('activo');
        
        // Establecer nuevo slide activo
        currentSlide = slideIndex;
        slides[currentSlide].classList.add('active');
        indicadores[currentSlide].classList.add('activo');
    }
    
    // Función para siguiente slide
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        changeSlide(nextIndex);
    }
    
    // Función para iniciar slider automático
    function startAutoSlider() {
        sliderInterval = setInterval(nextSlide, 4000); // Cambia cada 4 segundos
    }
    
    // Función para pausar slider automático
    function pauseAutoSlider() {
        clearInterval(sliderInterval);
    }
    
    // Agregar event listeners a los indicadores
    indicadores.forEach((indicador, index) => {
        indicador.addEventListener('click', () => {
            pauseAutoSlider();
            changeSlide(index);
            startAutoSlider(); // Reiniciar después del click
        });
    });
    
    // Pausar en hover y reanudar en mouse leave
    const sliderContainer = document.querySelector('.seccion-heroe');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', pauseAutoSlider);
        sliderContainer.addEventListener('mouseleave', startAutoSlider);
    }
    
    // Iniciar el slider automático
    startAutoSlider();
    
    console.log('Slider inicializado con', slides.length, 'slides');
}

// Función para inicializar animaciones
function initializeAnimations() {
    const opciones = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observador = new IntersectionObserver((entradas) => {
        entradas.forEach(entrada => {
            if (entrada.isIntersecting) {
                entrada.target.style.opacity = '1';
                entrada.target.style.transform = 'translateY(0)';
            }
        });
    }, opciones);
    
    // Observar tarjetas de servicio
    const tarjetasServicio = document.querySelectorAll('.tarjeta-servicio');
    tarjetasServicio.forEach(tarjeta => {
        tarjeta.style.opacity = '0';
        tarjeta.style.transform = 'translateY(20px)';
        tarjeta.style.transition = 'all 0.6s ease';
        observador.observe(tarjeta);
    });
}

// Función para desplazamiento suave
function initializeSmoothScroll() {
    const enlaces = document.querySelectorAll('a[href^="#"]');
    
    enlaces.forEach(enlace => {
        enlace.addEventListener('click', (e) => {
            e.preventDefault();
            const objetivo = document.querySelector(enlace.getAttribute('href'));
            
            if (objetivo) {
                objetivo.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Función para efectos de scroll en el encabezado
function initializeHeaderEffects() {
    const encabezado = document.querySelector('.encabezado');
    
    if (encabezado) {
        window.addEventListener('scroll', () => {
            // Mantener el encabezado sin sombra durante el scroll
            encabezado.style.boxShadow = 'none';
        });
    }
}

// Función principal de inicialización
function initialize() {
    initializeDropdown();
    initializeSlider();
    initializeAnimations();
    initializeSmoothScroll();
    initializeHeaderEffects();
    initializeHamburgerMenu();
    initializeAdminAccess();
}

// Función para inicializar el menú hamburguesa
function initializeHamburgerMenu() {
    const menuHamburguesa = document.getElementById('menuHamburguesa');
    const menuLateral = document.getElementById('menuLateral');
    const overlayMenu = document.getElementById('overlayMenu');
    const body = document.body;
    const desplegableMovil = document.querySelector('.desplegable-movil');
    const enlaceServiciosMovil = document.querySelector('.enlace-servicios-movil');
    
    if (!menuHamburguesa || !menuLateral || !overlayMenu) {
        return;
    }
    
    // Función para abrir el menú
    function abrirMenu() {
        menuLateral.classList.add('activo');
        overlayMenu.classList.add('activo');
        menuHamburguesa.classList.add('activo');
        body.style.overflow = 'hidden';
    }
    
    // Función para cerrar el menú
    function cerrarMenu() {
        menuLateral.classList.remove('activo');
        overlayMenu.classList.remove('activo');
        menuHamburguesa.classList.remove('activo');
        body.style.overflow = 'auto';
        // Cerrar también el submenú de servicios
        if (desplegableMovil) {
            desplegableMovil.classList.remove('activo');
        }
    }
    
    // Toggle del menú principal
    menuHamburguesa.addEventListener('click', (e) => {
        e.preventDefault();
        if (menuLateral.classList.contains('activo')) {
            cerrarMenu();
        } else {
            abrirMenu();
        }
    });
    
    // Toggle del submenú de servicios
    if (enlaceServiciosMovil && desplegableMovil) {
        enlaceServiciosMovil.addEventListener('click', (e) => {
            e.preventDefault();
            desplegableMovil.classList.toggle('activo');
        });
    }
    
    // Cerrar menú al hacer clic en el overlay
    overlayMenu.addEventListener('click', cerrarMenu);
    
    // Cerrar menú al hacer clic en un enlace (excepto servicios)
    const enlacesMenu = menuLateral.querySelectorAll('.enlaces-menu > li > a:not(.enlace-servicios-movil)');
    enlacesMenu.forEach(enlace => {
        enlace.addEventListener('click', cerrarMenu);
    });
    
    // Cerrar menú al hacer clic en un enlace de submenú
    const enlacesSubmenu = menuLateral.querySelectorAll('.submenu-servicios a');
    enlacesSubmenu.forEach(enlace => {
        enlace.addEventListener('click', cerrarMenu);
    });
    
    // Cerrar menú con la tecla Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menuLateral.classList.contains('activo')) {
            cerrarMenu();
        }
    });
    
    // Cerrar menú al cambiar el tamaño de la ventana (si se hace más grande)
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && menuLateral.classList.contains('activo')) {
            cerrarMenu();
        }
    });
}

// Función para inicializar servicios interactivos
function initializeServiciosInteractivos() {
    const servicioItems = document.querySelectorAll('.servicio-item');
    const detalleServicios = document.querySelectorAll('.detalle-servicio');
    
    if (servicioItems.length === 0 || detalleServicios.length === 0) {
        return; // No estamos en la página de servicios
    }
    
    // Inicializar estado por defecto: primer servicio activo, otros desactivados
    servicioItems.forEach((item, index) => {
        if (index === 0) {
            // El primer servicio debe estar activo
            item.classList.add('activo');
            // Mostrar su detalle correspondiente
            const servicioId = item.getAttribute('data-servicio');
            const detalleCorrespondiente = document.getElementById(`detalle-${servicioId}`);
            if (detalleCorrespondiente) {
                detalleCorrespondiente.classList.add('activo');
            }
        } else {
            // Los demás servicios están desactivados
            item.classList.add('desactivado');
        }
    });
    
    servicioItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remover clase activo y desactivado de todos los items
            servicioItems.forEach(i => {
                i.classList.remove('activo');
                i.classList.remove('desactivado');
            });
            detalleServicios.forEach(d => d.classList.remove('activo'));
            
            // Agregar clase activo al item clickeado
            item.classList.add('activo');
            
            // Agregar clase desactivado a todos los otros items
            servicioItems.forEach(i => {
                if (i !== item) {
                    i.classList.add('desactivado');
                }
            });
            
            // Mostrar el detalle correspondiente
            const servicioId = item.getAttribute('data-servicio');
            const detalleCorrespondiente = document.getElementById(`detalle-${servicioId}`);
            
            if (detalleCorrespondiente) {
                detalleCorrespondiente.classList.add('activo');
            }
        });
    });
    
    // Inicializar acordeones de tableros
    initializeTablerosAcordeones();
}

// Función para inicializar los acordeones de tableros
function initializeTablerosAcordeones() {
    const tablerosHeaders = document.querySelectorAll('.tablero-header');
    
    // Activar el primer acordeón (Tableros principales) por defecto
    if (tablerosHeaders.length > 0) {
        const primerHeader = tablerosHeaders[0];
        const primerContenido = primerHeader.nextElementSibling;
        primerHeader.classList.add('activo');
        if (primerContenido) {
            primerContenido.classList.add('activo');
        }
    }
    
    tablerosHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const contenido = header.nextElementSibling;
            const isActive = header.classList.contains('activo');
            
            // Cerrar todos los acordeones primero
            tablerosHeaders.forEach(otherHeader => {
                otherHeader.classList.remove('activo');
                const otherContenido = otherHeader.nextElementSibling;
                if (otherContenido) {
                    otherContenido.classList.remove('activo');
                }
            });
            
            // Si el acordeón no estaba activo, abrirlo
            if (!isActive) {
                header.classList.add('activo');
                contenido.classList.add('activo');
            }
            // Si ya estaba activo, se mantiene cerrado (ya se cerró arriba)
        });
    });
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initialize();
    initializeServiciosInteractivos();
    initializeProductos();
});

// También inicializar si la página ya está cargada
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initialize();
    initializeServiciosInteractivos();
    initializeProductos();
}

// ===============================
// PROYECTOS ALEATORIOS
// ===============================

// Todos los proyectos del portafolio
const todosLosProyectos = [
    {
        titulo: "Planta de Tratamiento de Agua Potable de Huachipa - SEDAPAL",
        imagen: "img/planta-sedapal-main.jpg",
        enlace: "planta-sedapal.html"
    },
    {
        titulo: "Nuevo Aeropuerto Internacional Jorge Chávez - LAP",
        imagen: "img/obra-aeropuerto.jpg",
        enlace: "aeropuerto.html"
    },
    {
        titulo: "Proyecto Alto Piura",
        imagen: "img/obra-alto-piura.jpg",
        enlace: "alto-piura.html"
    },
    {
        titulo: "Línea Amarilla - Vía Expresa Río Verde / Vía Parque Rímac",
        imagen: "img/obra-linea-amarilla.jpg",
        enlace: "linea-amarilla.html"
    },
    {
        titulo: "Metro de Lima - Línea 2",
        imagen: "img/obra-metro-lima.jpg",
        enlace: "metro-lima.html"
    },
    {
        titulo: "Laguna Huascacocha",
        imagen: "img/obra-laguna-huascacocha.jpg",
        enlace: "laguna.html"
    },
    {
        titulo: "Carretera Lima - Canta",
        imagen: "img/obra-carretera-canta.jpg",
        enlace: "carretera-lima.html"
    }
];

// Función para obtener el nombre del archivo actual
function obtenerPaginaActual() {
    const path = window.location.pathname;
    const nombreArchivo = path.split('/').pop();
    return nombreArchivo || 'index.html';
}

// Función para seleccionar proyectos aleatorios excluyendo el actual
function mostrarProyectosAleatorios() {
    const gridProyectos = document.querySelector('.grid-proyectos');
    if (!gridProyectos) return;

    const paginaActual = obtenerPaginaActual();
    
    // Filtrar proyectos excluyendo el proyecto actual
    const proyectosDisponibles = todosLosProyectos.filter(proyecto => {
        return proyecto.enlace !== paginaActual;
    });
    
    // Barajar el array de proyectos disponibles
    const proyectosBarajados = [...proyectosDisponibles].sort(() => Math.random() - 0.5);
    
    // Tomar los primeros 2
    const proyectosSeleccionados = proyectosBarajados.slice(0, 2);
    
    // Limpiar contenido actual
    gridProyectos.innerHTML = '';
    
    // Crear las tarjetas para los proyectos seleccionados
    proyectosSeleccionados.forEach(proyecto => {
        const tarjeta = document.createElement('div');
        tarjeta.className = 'tarjeta-proyecto';
        tarjeta.innerHTML = `
            <div class="imagen-proyecto-mini" style="background-image: url('${proyecto.imagen}');"></div>
            <div class="contenido-proyecto">
                <h3>${proyecto.titulo}</h3>
                <a href="${proyecto.enlace}" class="btn-conoce-mas">Conoce más</a>
            </div>
        `;
        gridProyectos.appendChild(tarjeta);
    });
}

// Inicializar proyectos aleatorios cuando se carga la página
document.addEventListener('DOMContentLoaded', mostrarProyectosAleatorios);

// ===============================
// PRODUCTOS INTERACTIVOS
// ===============================

// Función para inicializar la funcionalidad de productos
function initializeProductos() {
    const pestanasCategorias = document.querySelectorAll('.pestana-categoria');
    const productosGrids = document.querySelectorAll('.productos-grid');
    const descripciones = document.querySelectorAll('.descripcion-categoria p');
    
    if (pestanasCategorias.length === 0 || productosGrids.length === 0) {
        return; // No estamos en la página de productos
    }
    
    // Agregar event listeners a las pestañas
    pestanasCategorias.forEach(pestana => {
        pestana.addEventListener('click', () => {
            const categoria = pestana.getAttribute('data-categoria');
            
            // Remover clase activa de todas las pestañas
            pestanasCategorias.forEach(p => p.classList.remove('activa'));
            productosGrids.forEach(grid => grid.classList.remove('activo'));
            descripciones.forEach(desc => {
                desc.classList.remove('descripcion-activa');
                desc.classList.add('descripcion-oculta');
            });
            
            // Agregar clase activa a la pestaña seleccionada
            pestana.classList.add('activa');
            
            // Mostrar el grid de productos correspondiente
            const gridActivo = document.getElementById(`grid-${categoria}`);
            if (gridActivo) {
                gridActivo.classList.add('activo');
            }
            
            // Mostrar la descripción correspondiente
            const descripcionActiva = document.getElementById(`descripcion-${categoria}`);
            if (descripcionActiva) {
                descripcionActiva.classList.remove('descripcion-oculta');
                descripcionActiva.classList.add('descripcion-activa');
            }
        });
    });
    
}

// ===============================
// ACCESO SECRETO AL ADMINISTRADOR
// ===============================

// Función para inicializar acceso secreto al panel de administración
function initializeAdminAccess() {
    let konamiCode = [];
    const secretCode = ['r', 'e', 'h', 'o', 'b', 'o', 't']; // Código secreto: "rehobot"
    let adminButton = null;
    
    // Función para crear el botón de administrador oculto
    function createAdminButton() {
        if (adminButton) return; // Ya existe
        
        adminButton = document.createElement('div');
        adminButton.id = 'admin-secret-access';
        adminButton.innerHTML = `
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 1L3 5V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V5L12 1Z" 
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 12L11 14L15 10" stroke="currentColor" stroke-width="2" 
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        `;
        adminButton.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            color: white;
            transition: all 0.3s ease;
            z-index: 9999;
            opacity: 0;
            transform: scale(0);
        `;
        
        // Evento click para ir al panel de administración
        adminButton.addEventListener('click', () => {
            window.location.href = '/admin/login.html';
        });
        
        // Efectos hover
        adminButton.addEventListener('mouseenter', () => {
            adminButton.style.transform = 'scale(1.1)';
            adminButton.style.boxShadow = '0 6px 20px rgba(0,0,0,0.3)';
        });
        
        adminButton.addEventListener('mouseleave', () => {
            adminButton.style.transform = 'scale(1)';
            adminButton.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
        });
        
        document.body.appendChild(adminButton);
        
        // Animación de aparición
        setTimeout(() => {
            adminButton.style.opacity = '1';
            adminButton.style.transform = 'scale(1)';
        }, 100);
        
        // Auto-ocultar después de 10 segundos
        setTimeout(hideAdminButton, 10000);
    }
    
    // Función para ocultar el botón
    function hideAdminButton() {
        if (adminButton) {
            adminButton.style.opacity = '0';
            adminButton.style.transform = 'scale(0)';
            setTimeout(() => {
                if (adminButton) {
                    document.body.removeChild(adminButton);
                    adminButton = null;
                }
            }, 300);
        }
    }
    
    // Escuchar las teclas presionadas (solo cuando NO estés en un formulario)
    document.addEventListener('keydown', (e) => {
        // Verificar si el evento viene de un input, textarea o elemento editable
        const elementoActivo = document.activeElement;
        const esElementoFormulario = elementoActivo && (
            elementoActivo.tagName === 'INPUT' ||
            elementoActivo.tagName === 'TEXTAREA' ||
            elementoActivo.tagName === 'SELECT' ||
            elementoActivo.contentEditable === 'true'
        );
        
        // Si estamos escribiendo en un formulario, no procesar el código secreto
        if (esElementoFormulario) {
            return;
        }
        
        const key = e.key.toLowerCase();
        
        // Agregar la tecla al código actual
        konamiCode.push(key);
        
        // Mantener solo las últimas teclas necesarias
        if (konamiCode.length > secretCode.length) {
            konamiCode.shift();
        }
        
        // Verificar si el código coincide
        if (konamiCode.length === secretCode.length && 
            konamiCode.join('') === secretCode.join('')) {
            
            // Código correcto! Mostrar acceso de administrador
            konamiCode = []; // Resetear código
            createAdminButton();
            
            // Opcional: mostrar notificación discreta
            showDiscreteNotification('Acceso de administrador activado');
        }
    });
    
    // Función para mostrar notificación discreta
    function showDiscreteNotification(message) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 10000;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Mostrar notificación
        setTimeout(() => notification.style.opacity = '1', 100);
        
        // Ocultar y remover después de 3 segundos
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => document.body.removeChild(notification), 300);
        }, 3000);
    }
}
