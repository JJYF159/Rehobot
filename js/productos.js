// Funcionalidad del dropdown para móvil en productos
document.addEventListener('DOMContentLoaded', function() {
    const dropdownTrigger = document.getElementById('dropdownTrigger');
    const dropdownOpciones = document.getElementById('dropdownOpciones');
    const opcionesCategorias = document.querySelectorAll('.opcion-categoria');
    
    // Verificar que los elementos existen antes de agregar listeners
    if (!dropdownTrigger || !dropdownOpciones) {
        return; // Salir si no estamos en la página de productos
    }
    
    // Inicializar: ocultar el contenedor completo al cargar la página en móvil
    if (window.innerWidth <= 1470) {
        const contenedorCompleto = document.querySelector('.contenedor-productos-completo');
        if (contenedorCompleto) {
            contenedorCompleto.style.display = 'none';
        }
    }
    
    // Toggle del dropdown
    dropdownTrigger.addEventListener('click', function() {
        dropdownTrigger.classList.toggle('activo');
        dropdownOpciones.classList.toggle('activo');
        
        // Si se hace clic en "VER PRODUCTOS" cuando no hay categoría seleccionada
        if (dropdownTrigger.textContent.trim() === 'VER PRODUCTOS') {
            mostrarCategoria('ver-productos');
        }
    });
    
    // Cerrar dropdown cuando se hace clic fuera
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown-categorias')) {
            dropdownTrigger.classList.remove('activo');
            dropdownOpciones.classList.remove('activo');
        }
    });
    
    // Seleccionar categoría desde el dropdown
    opcionesCategorias.forEach(opcion => {
        opcion.addEventListener('click', function() {
            const categoria = this.getAttribute('data-categoria');
            const textoCategoria = this.textContent;
            
            // Actualizar el texto del botón
            dropdownTrigger.textContent = textoCategoria;
            
            // Cerrar dropdown
            dropdownTrigger.classList.remove('activo');
            dropdownOpciones.classList.remove('activo');
            
            // Mostrar productos de la categoría seleccionada
            mostrarCategoria(categoria);
        });
    });
    
    // Función para mostrar/ocultar categorías (reutilizada del código existente)
    function mostrarCategoria(categoria) {
        const contenedorCompleto = document.querySelector('.contenedor-productos-completo');
        
        // Si es "VER PRODUCTOS" o categoría por defecto, ocultar todo el contenedor
        if (categoria === 'ver-productos' || categoria === 'default' || !categoria) {
            if (contenedorCompleto) {
                contenedorCompleto.style.display = 'none';
            }
            return; // No mostrar nada
        }
        
        // Para categorías específicas, mostrar el contenedor
        if (contenedorCompleto) {
            contenedorCompleto.style.display = 'flex';
        }
        
        // Ocultar todos los grids
        document.querySelectorAll('.productos-grid').forEach(grid => {
            grid.classList.remove('activo');
        });
        
        // Ocultar todas las descripciones
        document.querySelectorAll('.descripcion-categoria p').forEach(desc => {
            desc.classList.remove('descripcion-activa');
            desc.classList.add('descripcion-oculta');
        });
        
        // Mostrar grid y descripción seleccionados para categorías específicas
        const gridSeleccionado = document.getElementById(`grid-${categoria}`);
        const descripcionSeleccionada = document.getElementById(`descripcion-${categoria}`);
        
        if (gridSeleccionado) {
            gridSeleccionado.classList.add('activo');
        }
        
        if (descripcionSeleccionada) {
            descripcionSeleccionada.classList.remove('descripcion-oculta');
            descripcionSeleccionada.classList.add('descripcion-activa');
        }
        
        // Remover clase activa de todas las pestañas
        document.querySelectorAll('.pestana-categoria').forEach(pestana => {
            pestana.classList.remove('activa');
        });
        
        // Agregar clase activa a la pestaña correspondiente (para desktop)
        const pestanaCorrespondiente = document.querySelector(`[data-categoria="${categoria}"]`);
        if (pestanaCorrespondiente && pestanaCorrespondiente.classList.contains('pestana-categoria')) {
            pestanaCorrespondiente.classList.add('activa');
        }
    }
    
    // Listener para cambios de tamaño de ventana
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 1470) {
            // En móvil/tablet: ocultar el contenedor completo si está en "VER PRODUCTOS"
            if (dropdownTrigger.textContent.trim() === 'VER PRODUCTOS') {
                const contenedorCompleto = document.querySelector('.contenedor-productos-completo');
                if (contenedorCompleto) {
                    contenedorCompleto.style.display = 'none';
                }
            }
        } else {
            // En desktop: mostrar el contenedor
            const contenedorCompleto = document.querySelector('.contenedor-productos-completo');
            if (contenedorCompleto) {
                contenedorCompleto.style.display = 'flex';
            }
        }
    });
});
