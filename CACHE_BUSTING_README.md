# Cache Busting Implementation - Rehobot Website

## ¿Qué se hizo?

Se implementó una solución de **cache busting** utilizando PHP para forzar la actualización automática del caché del navegador cada vez que se carga una página.

## Archivos modificados

### Archivos principales creados con cache busting:

1. **index.php** - Página principal
2. **Nosotros.php** - Página de nosotros
3. **servicios.php** - Página de servicios
4. **productos.php** - Página de productos
5. **Portafolio.php** - Página de portafolio
6. **contacto.php** - Página de contacto
7. **trabaja-con-nosotros.php** - Página de trabajo
8. **politica-privacidad.php** - Política de privacidad
9. **politica-calidad.php** - Política de calidad

### Páginas de proyectos creadas:

1. **aeropuerto.php** - Proyecto Aeropuerto
2. **alto-piura.php** - Proyecto Alto Piura
3. **carretera-lima.php** - Proyecto Carretera Lima
4. **laguna.php** - Proyecto Laguna
5. **linea-amarilla.php** - Proyecto Línea Amarilla
6. **metro-lima.php** - Proyecto Metro Lima
7. **planta-sedapal.php** - Proyecto Planta Sedapal

## ¿Cómo funciona?

Cada archivo CSS y JavaScript ahora incluye un parámetro de versión generado dinámicamente:

```html
<!-- Antes -->
<link rel="stylesheet" href="css/index.css">
<script src="js/script.js"></script>

<!-- Después -->
<link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
<script src="js/script.js?v=<?php echo time(); ?>"></script>
```

### Ejemplo de implementación:

El código `<?php echo time(); ?>` genera una marca de tiempo única cada vez que se carga la página, lo que hace que el navegador trate cada carga como un archivo nuevo, evitando problemas de caché.

## ¿Qué beneficios obtienes?

1. **Actualización automática**: Los cambios en CSS y JS se reflejan inmediatamente
2. **Sin configuración manual**: No necesitas cambiar versiones manualmente
3. **Compatible con todos los navegadores**: Funciona universalmente
4. **Fácil mantenimiento**: El sistema funciona automáticamente

## Instrucciones para usar en producción:

1. **Sube los archivos .php** al servidor en lugar de los .html
2. **Configura el servidor** para que sirva los archivos .php
3. **Actualiza los enlaces** en el servidor para apuntar a las versiones .php
4. **Verifica** que PHP esté habilitado en tu hosting

## Archivos originales:

Los archivos .html originales se mantuvieron como respaldo. Los archivos .php son las versiones activas con cache busting.

## Nota importante:

Este sistema requiere que el servidor tenga **PHP habilitado**. Si tu servidor no soporta PHP, puedes usar la alternativa de versiones manuales cambiando el `?v=1.0` por un número que incrementes cada vez que hagas cambios.

---

**Implementado el:** 29 de agosto de 2025  
**Para:** Proyecto Rehobot  
**Tipo:** Cache busting automático con PHP
