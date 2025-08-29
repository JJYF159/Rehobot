<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio - REHOBOT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preload" href="css/index.css?v=<?php echo time(); ?>" as="style">
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
    <link rel="preload" href="css/Portafolio.css?v=<?php echo time(); ?>" as="style">
    <link rel="stylesheet" href="css/Portafolio.css?v=<?php echo time(); ?>")
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
        <!-- Hero Portafolio -->
        <section class="hero-portafolio">
            <div class="imagen-hero-portafolio"></div>
            <div class="texto-hero-portafolio">
                <div class="circulo-azul-hero-portafolio"></div>
                <h1>Conoce nuestro <span>trabajo</span></h1>
                <p>En <strong>Corporación Rehobot</strong> contamos con una trayectoria consolidada en el desarrollo e implementación de soluciones técnicas para proyectos de infraestructura a nivel nacional. Nuestra participación abarca desde intervenciones locales hasta obras de gran escala, siempre con el compromiso de aportar <strong>calidad, seguridad y eficiencia operativa.</strong> Dentro de nuestro portafolio, hemos sido parte de proyectos considerados estratégicos por su impacto en el desarrollo poblacional e industrial, la gestión hídrica y el fortalecimiento del sistema de transporte e infraestructura pública del país. Estas obras reflejan nuestra capacidad para adaptarnos a entornos técnicos exigentes y cumplir con los más altos estándares del sector.</p>
                <p>A continuación, presentamos una muestra representativa de proyectos de alto impacto en los que hemos intervenido, con espacio para detallar los servicios específicos brindados por nuestra empresa.</p>
            </div>
        </section>

        <!-- Sección Listado de obras -->
        <section class="seccion-listado-obras">
            <div class="contenedor">
                <h2>Listado de <span>Obras.</span></h2>

                <div class="grid-obras">
                    <!-- Planta de Tratamiento de Agua Potable -->
                    <div class="tarjeta-obra" data-categoria="agua">
                        <div class="imagen-obra" style="background-image: url('img/obra-planta-agua.jpg');"></div>
                        <div class="contenido-obra">
                            <h3>Planta de Tratamiento de Agua Potable de Huachipa - SEDAPAL</h3>
                            <a href="planta-sedapal.html" class="btn-conoce-mas">Conoce más</a>
                        </div>
                    </div>

                    <!-- Proyecto Alto Piura -->
                    <div class="tarjeta-obra" data-categoria="agua">
                        <div class="imagen-obra" style="background-image: url('img/obra-alto-piura.jpg');"></div>
                        <div class="contenido-obra">
                            <h3>Proyecto Alto Piura</h3>
                            <a href="alto-piura.html" class="btn-conoce-mas">Conoce más</a>
                        </div>
                    </div>

                    <!-- Nuevo Aeropuerto -->
                    <div class="tarjeta-obra" data-categoria="transporte">
                        <div class="imagen-obra" style="background-image: url('img/obra-aeropuerto.jpg');"></div>
                        <div class="contenido-obra">
                            <h3>Nuevo Aeropuerto Internacional Jorge Chávez - LAP</h3>
                            <a href="aeropuerto.html" class="btn-conoce-mas">Conoce más</a>
                        </div>
                    </div>

                    <!-- Línea Amarilla -->
                    <div class="tarjeta-obra" data-categoria="transporte">
                        <div class="imagen-obra" style="background-image: url('img/obra-linea-amarilla.jpg');"></div>
                        <div class="contenido-obra">
                            <h3>Línea Amarilla - Vía Expresa Río Verde / Vía Parque Rímac</h3>
                            <a href="linea-amarilla.html" class="btn-conoce-mas">Conoce más</a>
                        </div>
                    </div>

                    <!-- Metro de Lima -->
                    <div class="tarjeta-obra" data-categoria="transporte">
                        <div class="imagen-obra" style="background-image: url('img/obra-metro-lima.jpg');"></div>
                        <div class="contenido-obra">
                            <h3>Metro de Lima - Línea 2</h3>
                            <a href="metro-lima.html" class="btn-conoce-mas">Conoce más</a>
                        </div>
                    </div>

                    <!-- Laguna Huascacocha -->
                    <div class="tarjeta-obra" data-categoria="mineria">
                        <div class="imagen-obra" style="background-image: url('img/obra-laguna-huascacocha.jpg');"></div>
                        <div class="contenido-obra">
                            <h3>Laguna Huascacocha</h3>
                            <a href="#" class="btn-conoce-mas">Conoce más</a>
                        </div>
                    </div>

                    <!-- Carretera Lima - Canta -->
                    <div class="tarjeta-obra" data-categoria="infraestructura">
                        <div class="imagen-obra" style="background-image: url('img/obra-carretera-canta.jpg');"></div>
                        <div class="contenido-obra">
                            <h3>Carretera Lima - Canta</h3>
                            <a href="carretera-lima.html" class="btn-conoce-mas">Conoce más</a>
                        </div>
                    </div>
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


