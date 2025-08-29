<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carretera Lima – Canta - REHOBOT</title>
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
                            <li><a href="servicios.html">Diseño y Perforación de Pozos Subterráneos</a></li>
                            <li><a href="servicios.html">Instalaciones Electromecánicas Automatizadas</a></li>
                            <li><a href="servicios.html">Instalaciones Eléctricas y Sistemas de Control</a></li>
                            <li><a href="servicios.html">Fabricación, Instalación y Mantenimiento de Tableros Eléctricos</a></li>
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
                    <h1 class="titulo-proyecto">Carretera Lima – Canta</h1>
                </div>
                <div class="cuadro_ubicacion">
                    <div class="ubicacion-proyecto">
                    <span class="icono-ubicacion"><img src="svg/IconoMap.svg" alt=""></span>
                        Lima – Región Sierra Central
                    </div>
                </div>
                
            </section>

            <!-- Sección de información del proyecto -->
            <section class="seccion-info-proyecto">
                <div class="grid-info">
                    <div class="info-columna">
                        <h3>Importancia</h3>
                        <p>Proyecto vial estratégico que constituye una ruta alterna a la Carretera Central, mejorando la conectividad entre Lima y la sierra central, reduciendo tiempos de viaje y descongestionando el principal corredor logístico del país.</p>
                    </div>
                    <div class="separador-vertical"></div>
                    <div class="info-columna">
                        <h3>Descripción del proyecto</h3>
                        <p>Construcción y mejoramiento integral de la vía Lima – Canta – Huayllay, incluyendo obras de movimiento de tierras, estructuras, sistemas de drenaje y habilitación de campamentos operativos.</p>
                    </div>
                </div>
            </section>

            <!-- Sección de participación -->
            <section class="seccion-participacion">
                <div class="contenido-participacion">
                    <div class="circulo-azul-decorativo"></div>
                    <div class="info-participacion">
                        <h2>Participación de Corporación Rehobot</h2>
                        <p>Se ejecutó la implementación integral del sistema de abastecimiento de agua y la electrificación del campamento principal, donde se desarrolló la puesta en marcha y el control operativo del proyecto.</p>
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
                            <li><strong>Perforación y habilitación de un pozo tubular</strong> como fuente propia para el suministro de agua.</li>
                            <li><strong>Instalación del sistema de bombeo y línea de conducción</strong> para el llenado de los tanques reservorios del campamento.</li>
                            <li><strong>Diseño e implementación de redes eléctricas</strong> en media y baja tensión, asegurando energía confiable para la operación.</li>
                            <li><strong>Instalación de pozos a tierra</strong> en todo el campamento, cumpliendo estándares de seguridad eléctrica.</li>
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
                    <h4>Corporacié³n Rehobot</h4>
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



