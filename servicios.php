<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - REHOBOT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preload" href="css/index.css?v=<?php echo time(); ?>" as="style">
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <link rel="preload" href="css/servicios.css?v=<?php echo time(); ?>" as="style">
    <link rel="stylesheet" href="css/servicios.css?v=<?php echo time(); ?>")
</head>
<body>
    <header class="encabezado">
        <nav class="barra-navegacion">
            <!-- Botón hamburguesa para móviles -->
            <button class="menu-hamburguesa" id="menuHamburguesa">
                <span class="linea"></span>
                <span class="linea"></span>
                <span class="linea"></span>
            </button>
            
            <ul class="enlaces-principales enlaces-izquierda">
                <li><a href="Nosotros.html">Nosotros</a></li>
                <li class="desplegable">
                    <a href="servicios.html" class="enlace-desplegable">Servicios <span class="flecha"><img src="svg/weui_arrow-filled.svg" alt="flecha"></span></a>
                </li>
            </ul>
            <div class="logotipo">
                <a href="index.html">
                    <img src="svg/Logo - Rehobot completo.svg" alt="REHOBOT Logo" width="120" height="40">
                </a>
            </div>
            <ul class="enlaces-principales enlaces-derecha">
                <li><a href="productos.html">Productos</a></li>
                <li><a href="Portafolio.html">Portafolio</a></li>
            </ul>
            <div class="boton-contacto" id="btnContacto">
            <a href="contacto.html">
                <button>Contacto</button>
            </a>
            </div>
        </nav>
        
        <!-- Menú lateral para móviles -->
        <div class="menu-lateral" id="menuLateral">
            <div class="contenido-menu">
                <ul class="enlaces-menu">
                    <li><a href="Nosotros.html">Nosotros</a></li>
                    <li class="desplegable-movil">
                        <a href="servicios.html" class="enlace-servicios-movil">Servicios <span class="flecha-movil">▼</span></a>
                        <ul class="submenu-servicios">
                            <li class="submenu-header">
                                <a href="#" class="btn-regresar">
                                    <span class="flecha-regresar">◀</span>
                                    <span>Servicios</span>
                                </a>
                            </li>
                            <li><a href="servicios.html">
                                <img src="svg/diseno-perforacion-pozos.svg" alt="Diseño y Perforación" class="icono-servicio-mini">
                                Diseño y Perforación de Pozos Subterráneos
                            </a></li>
                            <li><a href="servicios.html">
                                <img src="svg/instalaciones-electromecanicas.svg" alt="Instalaciones Electromecánicas" class="icono-servicio-mini">
                                Instalaciones Electromecánicas Automatizadas
                            </a></li>
                            <li><a href="servicios.html">
                                <img src="svg/instalaciones-electricas.svg" alt="Instalaciones Eléctricas" class="icono-servicio-mini">
                                Instalaciones Eléctricas y Sistemas de Control
                            </a></li>
                            <li><a href="servicios.html">
                                <img src="svg/fabricacion-instalacion-mantenimiento-tableros.svg" alt="Fabricación de Tableros" class="icono-servicio-mini">
                                Fabricación, Instalación y Mantenimiento de Tableros Eléctricos
                            </a></li>
                        </ul>
                    </li>
                    <li><a href="productos.html">Productos</a></li>
                    <li><a href="Portafolio.html">Portafolio</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                </ul>
            </div>
        </div>
        
        <!-- Overlay -->
        <div class="overlay-menu" id="overlayMenu"></div>
    </header>
    
    <div class="contenido-desplegable">
        <a href="servicios.html" class="elemento-desplegable">
            <div class="icono">
                <img src="svg/diseno-perforacion-pozos.svg" alt="Diseño y Perforación de Pozos">
            </div>
            <div class="contenido">
                <h4>Diseño y Perforación de Pozos Subterráneos</h4>
            </div>
        </a>
        <div class="separador"></div>
        <a href="servicios.html" class="elemento-desplegable">
            <div class="icono">
                <img src="svg/instalaciones-electromecanicas.svg" alt="Instalaciones Electromecánicas">
            </div>
            <div class="contenido">
                <h4>Instalaciones Electromecánicas Automatizadas</h4>
            </div>
        </a>
        <div class="separador"></div>
        <a href="servicios.html" class="elemento-desplegable">
            <div class="icono">
                <img src="svg/instalaciones-electricas.svg" alt="Instalaciones Eléctricas">
            </div>
            <div class="contenido">
                <h4>Instalaciones Eléctricas y Sistemas de Control</h4>
            </div>
        </a>
        <div class="separador"></div>
        <a href="servicios.html" class="elemento-desplegable">
            <div class="icono">
                <img src="svg/tableros-electricos.svg" alt="Tableros Eléctricos">
            </div>
            <div class="contenido">
                <h4>Fabricación, Instalación y Mantenimiento de Tableros Eléctricos</h4>
            </div>
        </a>
    </div>


    <main>
        <!-- Hero Servicios -->
        <section class="hero-servicios">
            <div class="imagen-hero-servicios"></div>
            <div class="imagen-hero-servicios_inferior"></div>
            <div class="texto-hero-servicios">
                <div class="circulo-azul-hero-servicios"></div>
                <h1>Nuestros <span>servicios</span></h1>
                <p>En <strong>Corporación Rehobot</strong> ofrecemos soluciones integrales y especializadas en proyectos de infraestructura hídrica, electromecánica y eléctrica. Nuestro enfoque combina <strong>experiencia técnica, equipos de alta precisión</strong> y un firme compromiso con la calidad, la eficiencia y la sostenibilidad.</p>
                <p>Contamos con un catálogo diversificado que nos permite intervenir en todas las etapas de un proyecto: <strong>diseño, ejecución, implementación y mejoras continuas, como también el mantenimiento y rehabilitación</strong>. Ya sea para el sector construcción, industrial, minero, agroindustrial y entidades del estado, adecuando cada servicio a las necesidades específicas de nuestros clientes, garantizando resultados confiables y duraderos.</p>
            </div>
        </section>

        <!-- Sección Servicios Principales -->
        <section class="seccion-servicios-principales">
            <div class="contenedor">
                <h2>Conoce nuestras principales líneas de servicios.</h2>
                <div class="contenido-servicios-interactivo">
                    <!-- Lista de servicios a la izquierda -->
                    <div class="lista-servicios">
                        <div class="servicio-item" data-servicio="pozos">
                            <h3>Diseño y Perforación de Pozos para Abastecimiento del Recurso Hídrico Subterráneo</h3>
                        </div>
                        <div class="servicio-item" data-servicio="electromecanicas">
                            <h3>Instalaciones Electromecánicas Automatizadas</h3>
                        </div>
                        <div class="servicio-item" data-servicio="electricas">
                            <h3>Instalaciones Eléctricas y Sistemas de Control</h3>
                        </div>
                        <div class="servicio-item" data-servicio="tableros">
                            <h3>Fabricación, Instalación y Mantenimiento de Tableros Eléctricos</h3>
                        </div>
                    </div>
                    
                    <!-- Información detallada a la derecha -->
                    <div class="informacion-servicio">
                        <!-- Información para Pozos -->
                        <div class="detalle-servicio" id="detalle-pozos">
                            <ul class="lista-detalles">
                                <li>Estudios hidrogeológicos</li>
                                <li>Trámites de licencias</li>
                                <li>Perforación de pozos tubulares profundos.</li>
                                <li>Mantenimiento integral de pozos tubulares profundos</li>
                                <li>Rehabilitación de pozos tubulares profundos.</li>
                                <li>Inspección del estado estructural del pozo con cámara de video 4K</li>
                                <li>Equipamiento del sistema de bombeo de pozos tubulares profundos.</li>
                                <li>Diseño, instalación y mantenimiento de árbol hidráulico del sistema de bombeo de pozo</li>
                                <li>Fabricación en torno de roscas para tuberías de pozos</li>
                                <li>Fabricación de tuberías bridadas para pozos.</li>
                                <li>Diseño, instalación de red de conducción desde el pozo hasta tanque reservorio</li>
                                <li>Mantenimiento de equipos de bombeo</li>
                                <li>Rebobinado de motores sumergibles para pozo</li>
                            </ul>
                        </div>
                        
                        <!-- Información para Electromecánicas -->
                        <div class="detalle-servicio" id="detalle-electromecanicas">
                            <ul class="lista-detalles">
                                <li>Sistema de abastecimiento de agua por bombeo a tanques reservorios.</li>
                                <li>Sistema de presión constante</li>
                                <li>Sistema contra incendio</li>
                                <li>Sistema de bombeo solar</li>
                                <li>Sistema de drenaje</li>
                                <li>Sistema de tratamiento de agua</li>
                                <li>Sistema de riego</li>
                            </ul>
                        </div>
                        
                        <!-- Información para Eléctricas -->
                        <div class="detalle-servicio" id="detalle-electricas">
                            <ul class="lista-detalles">
                                <li>Diseño y ejecución de obras eléctricas, Sistemas de utilización, subsistema de distribución.</li>
                                <li>Montaje y mantenimiento de Subestaciones del tipo aéreas, biposte y/o monoposte, convencionales, casetas, modulares tipo bloque y compactas.</li>
                                <li>Tendido de Red aérea y subterránea, MT y BT.</li>
                                <li>Diseño, Instalación y mantenimiento de Sistemas de Pozo Puestas a Tierra (vertical, horizontal y de malla).</li>
                            </ul>
                        </div>
                        
                        <!-- Información para Tableros -->
                        <div class="detalle-servicio tableros-electricos" id="detalle-tableros">
                            <div class="tableros-principales">
                                <div class="tablero-item desplegable-tablero">
                                    <div class="tablero-header">
                                        <span class="icono-triangulo">▶</span> Tableros principales
                                    </div>
                                    <div class="tablero-contenido activo">
                                        <p>Reciben la alimentación principal y la distribuyen a los circuitos secundarios.</p>
                                        <ol class="lista-numerada">
                                            <li>Tableros principales para uso residencial</li>
                                            <li>Tableros principales para uso comercial</li>
                                            <li>Tableros principales para uso Industrial de los diferentes sectores de explotación y producción.</li>
                                        </ol>
                                    </div>
                                </div>
                                
                                <div class="otros-tableros">
                                    <div class="tablero-item desplegable-tablero">
                                        <div class="tablero-header">
                                            <span class="icono-triangulo">▶</span> Tableros de distribución
                                        </div>
                                        <div class="tablero-contenido">
                                            <p>Distribuyen la energía eléctrica desde el tablero principal hacia diferentes circuitos secundarios en una instalación.</p>
                                            <ul>
                                                <li>Tableros de distribución residencial</li>
                                                <li>Tableros de distribución comercial</li>
                                                <li>Tableros de distribución industrial</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tablero-item desplegable-tablero">
                                        <div class="tablero-header">
                                            <span class="icono-triangulo">▶</span> Tableros de fuerza
                                        </div>
                                        <div class="tablero-contenido">
                                            <p>Diseñados específicamente para alimentar equipos de alta potencia y motores industriales.</p>
                                            <ul>
                                                <li>Tableros para motores trifásicos</li>
                                                <li>Tableros para equipos de soldadura</li>
                                                <li>Tableros para maquinaria pesada</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tablero-item desplegable-tablero">
                                        <div class="tablero-header">
                                            <span class="icono-triangulo">▶</span> Tableros de arranque de motor
                                        </div>
                                        <div class="tablero-contenido">
                                            <p>Controlan el arranque, parada y protección de motores eléctricos de diferentes potencias.</p>
                                            <ul>
                                                <li>Arranque directo (DOL)</li>
                                                <li>Arranque estrella-triángulo</li>
                                                <li>Arranque suave con variadores de frecuencia</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tablero-item desplegable-tablero">
                                        <div class="tablero-header">
                                            <span class="icono-triangulo">▶</span> Tableros de control
                                        </div>
                                        <div class="tablero-contenido">
                                            <p>Sistemas de control automatizado para procesos industriales y monitoreo de equipos.</p>
                                            <ul>
                                                <li>Control de procesos automatizados</li>
                                                <li>Sistemas de monitoreo remoto</li>
                                                <li>Control de iluminación inteligente</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tablero-item desplegable-tablero">
                                        <div class="tablero-header">
                                            <span class="icono-triangulo">▶</span> Tableros para bancos de condensadores
                                        </div>
                                        <div class="tablero-contenido">
                                            <p>Mejoran el factor de potencia y reducen el consumo de energía reactiva en instalaciones industriales.</p>
                                            <ul>
                                                <li>Compensación automática de reactivos</li>
                                                <li>Control inteligente de condensadores</li>
                                                <li>Monitoreo de factor de potencia</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tablero-item desplegable-tablero">
                                        <div class="tablero-header">
                                            <span class="icono-triangulo">▶</span> Tableros de transferencia automática
                                        </div>
                                        <div class="tablero-contenido">
                                            <p>Garantizan la continuidad del suministro eléctrico mediante el cambio automático entre fuentes de energía.</p>
                                            <ul>
                                                <li>Transferencia red-grupo electrógeno</li>
                                                <li>Transferencia entre dos redes eléctricas</li>
                                                <li>Sistemas UPS integrados</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="boton-mas-info">
                    <button class="btn-mas-informacion"><a href="contacto.html">Más información aquí</a></button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="pie-pagina">
        <div class="contenedor">
            <div class="contenido-footer">
                <div class="columna-footer">
                    <div class="logo-footer">
                        <img src="svg/Logo-footer.svg" alt="">
                    </div>
                    <div class="siguenos-texto">Síguenos:</div>
                    <div class="redes-sociales">
                        <a href="#" class="red-social facebook">
                            <img src="svg/facebook.svg" alt="Facebook">
                        </a>
                        <a href="#" class="red-social instagram">
                            <img src="svg/instagram.svg" alt="Instagram">
                        </a>
                        <a href="#" class="red-social tiktok">
                            <img src="svg/tiktok.svg" alt="TikTok">
                        </a>
                        <a href="#" class="red-social linkedin">
                            <img src="svg/linkedin.svg" alt="LinkedIn">
                        </a>
                        <a href="#" class="red-social youtube">
                            <img src="svg/youtube.svg" alt="YouTube">
                        </a>
                    </div>
                </div>
                <div class="columna-footer">
                    <h4>Corporación Rehobot</h4>
                    <ul>
                        <li><a href="Nosotros.html">Sobre nosotros</a></li>
                        <li><a href="productos.html">Nuestros productos</a></li>
                        <li><a href="servicios.html">Nuestros Servicios</a></li>
                    </ul>
                </div>
                <div class="columna-footer">
                    <h4>Otros Enlaces</h4>
                    <ul>
                        <li><a href="trabaja-con-nosotros.html">Trabaja con nosotros</a></li>
                        <li><a href="politica-privacidad.html">Política de privacidad y uso<br>de datos personales</a></li>
                        <li><a href="politica-calidad.html">Política de calidad</a></li>
                    </ul>
                </div>
                <div class="columna-footer">
                    <h4>Contacto</h4>
                    <ul>
                        <li><a href="mailto:info@corporacionrehobot.com">info@corporacionrehobot.com</a></li>
                        <li><a href="tel:+51989011132">(51) 989 011 132</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-inferior">
                <div class="copyright">© 2025 Rehobot. Todos los derechos reservados.</div>
                <div class="empresa-info">Corporación Rehobot Contratistas Generales. S.A.C - RUC 20538056988</div>
            </div>
        </div>
    </footer>

    <script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>
</html>


