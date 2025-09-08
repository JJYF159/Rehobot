<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metro de Lima – Línea 2 - REHOBOT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preload" href="css/index.css?v=<?php echo time(); ?>" as="style">
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <link rel="preload" href="css/planta-sedapal.css?v=<?php echo time(); ?>" as="style">
    <link rel="stylesheet" href="css/proyectos.css?v=<?php echo time(); ?>">
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
        <div class="contenedor">
            <!-- Header del proyecto -->
            <section class="header-proyecto">
                <div class="imagen-proyecto" style="background-image: url('img/planta-sedapal-main.jpg');"></div>
                <div class="titulo-con-flecha">
                    <a href="Portafolio.html" class="btn-regreso">
                        <img src="svg/flecha.svg" alt="Regresar">
                    </a>
                    <h1 class="titulo-proyecto">Metro de Lima – Línea 2</h1>
                </div>
                <div class="cuadro_ubicacion">
                    <div class="ubicacion-proyecto">
                    <span class="icono-ubicacion"><img src="svg/IconoMap.svg" alt=""></span>
                        Lima Metropolitana
                    </div>
                </div>
                
            </section>

            <!-- Sección de información del proyecto -->
            <section class="seccion-info-proyecto">
                <div class="grid-info">
                    <div class="info-columna">
                        <h3>Importancia</h3>
                        <p>Primer sistema de metro subterráneo del país. Forma parte del sistema de transporte masivo que reducirá la congestión y el tiempo de traslado en Lima, beneficiando a millones de usuarios.</p>
                    </div>
                    <div class="separador-vertical"></div>
                    <div class="info-columna">
                        <h3>Descripción del proyecto</h3>
                        <p>Proyecto de Más de 35 km de vía subterránea, 27 estaciones, 7 pozos de ventilación y un patio taller.</p>
                    </div>
                </div>
            </section>

            <!-- Sección de participación -->
            <section class="seccion-participacion">
                <div class="contenido-participacion">
                    <div class="circulo-azul-decorativo"></div>
                    <div class="info-participacion">
                        <h2>Participación de Corporación Rehobot</h2>
                        <p>Se ejecutaron trabajos especializados para <strong>captación y gestión del recurso hídrico subterráneo</strong>, incluyendo perforación, rehabilitación, equipamiento y mantenimiento de pozos, así como la implementación de sistemas auxiliares en varias estaciones.</p>
                    </div>
                    <div class="imagen-participacion"></div>
                </div>
            </section>

            <!-- Sección de actividades -->
            <section class="seccion-actividades">
                <h2 class="actividades-titulo">Actividades <span>desarrolladas.</span></h2>
                <div class="contenido-actividades">
                    <div class="tarjeta-actividad">
                    </div>
                    <div class="tarjeta-lista-actividades">
                        <ul class="lista-actividades">
                            <li><strong>Estación Santa Anita:</strong> Rehabilitación y equipamiento de un pozo existente.</li>
                            <li><strong>Estación 19:</strong> Perforación de un pozo e instalación de una garza para abastecimiento mediante cisternas.</li>
                            <li><strong>Estación 20:</strong> Elaboración de estudio hidrogeológico, obtención de licencia ante la ANA, perforación del pozo y equipamiento completo.</li>
                            <li><strong>Estación 3 (Callao):</strong> Participación en el sistema de dewatering, mediante perforación de pozos y piezómetros para control del nivel freático.</li>
                            <li><strong>Mantenimiento preventivo y correctivo</strong> pozos y equipos de bombeo en las estaciones 19, 20 y Santa Anita.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Sección Más proyectos -->
            <section class="seccion-mas-proyectos">
                <h2 class="mas-proyectos-titulo">Más <span>proyectos.</span></h2>
                <div class="grid-proyectos">
                    <!-- Los proyectos se cargarán dinámicamente con JavaScript -->
                </div>
            </section>
        </div>
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



