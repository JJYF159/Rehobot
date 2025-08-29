<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REHOBOT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link rel="preload" href="css/index.css?v=<?php echo time(); ?>" as="style">
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>")
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

    <main class="contenido-principal">
        <!-- Sección Hero -->
        <section class="seccion-heroe">
            <div class="slides-container">
                <!-- Slide 1 -->
                <div class="slide active" data-slide="0">
                    <div class="contenido-heroe">
                        <div class="texto-heroe">
                            <div class="circulo-azul"></div>
                            <div class="cuadro-texto">
                                <h1>Especialistas en perforación de pozos tubulares profundos.</h1>
                                <p>Captación eficiente y segura de agua subterránea para uso agrícola, industrial y doméstico.</p>
                                <button class="boton-principal"><a href="contacto.html">Cotiza Aquí</a></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="slide" data-slide="1">
                    <div class="contenido-heroe">
                        <div class="texto-heroe">
                            <div class="circulo-azul"></div>
                            <div class="cuadro-texto">
                                <h1>Soluciones automatizadas para mayor eficiencia operativa.</h1>
                                <p>Sistemas eléctricos integrales, tableros de control, PLCs, variadores de frecuencia y más.</p>
                                <button class="boton-principal"><a href="contacto.html">Cotiza Aquí</a></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="slide" data-slide="2">
                    <div class="contenido-heroe">
                        <div class="texto-heroe">
                            <div class="circulo-azul"></div>
                            <div class="cuadro-texto">
                                <h1>Mantenimientos integrales de infraestructura y equipos.</h1>
                                <p>Conservamos la operatividad de tus sistemas eléctricos, hidráulicos, sanitarios y mecánicos.</p>
                                <button class="boton-principal"><a href="contacto.html">Cotiza Aquí</a></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 4 -->
                <div class="slide" data-slide="3">
                    <div class="contenido-heroe">
                        <div class="texto-heroe">
                            <div class="circulo-azul"></div>
                            <div class="cuadro-texto">
                                <h1>Soluciones profesionales en sistemas contra incendios.</h1>
                                <p>Diseño, instalación, mantenimiento y pruebas hidráulicas 100% certificadas.Cumplimos normativa nacional e internacional.</p>
                                <button class="boton-principal"><a href="contacto.html">Cotiza Aquí</a></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 5 -->
                <div class="slide" data-slide="4">
                    <div class="contenido-heroe">
                        <div class="texto-heroe">
                            <div class="circulo-azul"></div>
                            <div class="cuadro-texto">
                                <h1>Equipos de bombeo para cada necesidad.</h1>
                                <p>Venta, instalación y puesta en marcha de bombas de agua, bombas sumergibles, sistemas de presión constante y soluciones hidráulicas especializadas.</p>
                                <button class="boton-principal"><a href="contacto.html">Cotiza Aquí</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="indicadores">
                <span class="indicador activo" data-slide="0"></span>
                <span class="indicador" data-slide="1"></span>
                <span class="indicador" data-slide="2"></span>
                <span class="indicador" data-slide="3"></span>
                <span class="indicador" data-slide="4"></span>
            </div>
        </section>

        <!-- Sección Servicios -->
        <section class="seccion-servicios">
            <div class="contenedor">
                <h2>Para cada necesidad, una <span>solución.</span></h2>
                <p>Con años de experiencia en el sector, ofrecemos soluciones <span>eficientes y personalizadas</span> para cada requerimiento de nuestros clientes.</p>
                <div class="cuadricula-servicios">
                    <div class="tarjeta-servicio">
                        <div class="icono-servicio">
                            <img src="svg/diseño-perforacion-pozos-recurso.svg" alt="Diseño y Perforación de Pozos">
                        </div>
                        <div class="contenido-tarjeta">
                            <h3>Diseño y perforación de pozos para el abastecimiento del recurso hídrico subterráneo</h3>
                            <button class="boton-servicio"><a href="servicios.html">Ir al servicio</a></button>
                        </div>
                    </div>
                    <div class="tarjeta-servicio">
                        <div class="icono-servicio">
                            <img src="svg/instalaciones-electromecanicas.svg" alt="Instalaciones Electromecánicas">
                        </div>
                        <div class="contenido-tarjeta">
                            <h3>Instalaciones electromecánicas automatizadas</h3>
                            <button class="boton-servicio"><a href="servicios.html">Ir al servicio</a></button>
                        </div>
                    </div>
                    <div class="tarjeta-servicio">
                        <div class="icono-servicio">
                            <img src="svg/instralacion-electricas-sistemas-control.svg" alt="Instalaciones Eléctricas">
                        </div>
                        <div class="contenido-tarjeta">
                            <h3>Instalaciones eléctricas y sistemas de control</h3>
                            <button class="boton-servicio"><a href="servicios.html">Ir al servicio</a></button>
                        </div>
                    </div>
                    <div class="tarjeta-servicio">
                        <div class="icono-servicio">
                            <img src="svg/fabricacion-instalacion-mantenimiento-tableros.svg" alt="Tableros Eléctricos">
                        </div>
                        <div class="contenido-tarjeta">
                            <h3>Fabricación, instalación y mantenimiento de tableros eléctricos</h3>
                            <button class="boton-servicio"><a href="servicios.html">Ir al servicio</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección Sobre Nosotros -->
        <section class="seccion-nosotros">
            <div class="contenedor">
                <div class="contenido-nosotros">
                    <div class="imagen-nosotros"></div>
                    <div class="texto-nosotros">
                        <div class="tarjeta-nosotros">
                            <div class="circulo-azul circulo-azul-nosotros"></div>
                            <h2>Sobre <span>nosotros.</span></h2>
                            <p>Somos una empresa con más de <span>30 años de experiencia</span>, especializada en brindar soluciones integrales para el abastecimiento del recurso hídrico, que gestiona proyectos desde la consultoría hasta su ejecución y puesta en marcha, orientados a cubrir las diversas necesidades de los sectores construcción, industrial, minero, agroindustrial y otros rubros afines. Contamos con un equipo <span>profesional altamente calificado y el respaldo operativo</span> para desarrollar proyectos de alto impacto con eficiencia, calidad y compromiso.</p>
                            <button class="boton-principal btn-nosotros"><a href="nosotros.html">Conoce más aquí</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección ANA -->
        <section class="seccion-ana">
            <div class="contenedor">
                <div class="contenido-ana">
                    <div class="texto-ana">
                        <h2>Autorizados por el ANA</h2>
                        <p>Corporación REHOBOT cuenta con autorización oficial de la Autoridad Nacional del Agua (ANA) para realizar actividades de <span>perforación, equipamiento, rehabilitación y mantenimiento de pozos de agua</span>, lo que garantiza el cumplimiento de la normativa vigente y respalda nuestra capacidad técnica y legal.</p>
                        <button class="btn-ANA"><a href="contacto.html">Contáctanos</a></button>
                    </div>
                    <div class="logo-ana">
                        <div class="imagen-ana">
                            <img src="img/ANA.jpg" alt="Logo ANA">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección Territorio -->
        <section class="seccion-territorio">
            <div class="contenedor">
                <div class="contenido-territorio">
                    <div class="mapa-peru"></div>
                    <div class="texto-territorio">
                        <div class="circulo-azul circulo-azul-TN"></div>
                        <div class="texto-TN">
                            <h2>Ejecutamos proyectos en todo el <span>territorio nacional.</span></h2>
                            <button class="boton-principal btn-territorio"><a href="contacto.html">Contáctanos</a></button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección Clientes -->
        <section class="seccion-clientes">
            <div class="contenedor">
                <h2>Nuestros clientes nos respaldan.</h2>
                <div class="carrusel-clientes">
                    <div class="logos-clientes">
                        <!-- Primera serie de logos -->
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763006/YASISA-LOGO_lu66ww.png" alt="Yasisa">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763005/TOTTUS-LOGO_zeion4.png" alt="Tottus">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763003/TEIGA-TMI_qz9r0t.png" alt="Teiga TMI">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763002/PESQUERA-DIAMANTE_lfyc2v.png" alt="Pesquera Diamante">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763001/PESQUERA-CENTINELA_pnbz1i.png" alt="Pesquera Centinela">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762999/MODASA-LOGO_iyy10x.png" alt="Modasa">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762998/LIMA-EXPRESA-LOGO_haohgq.png" alt="Lima Expresa">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762996/JOCKEY-PLAZA-LOGO_rvhdbm.png" alt="Jockey Plaza">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762995/GRUPO-CENTENARIO_auwrrq.png" alt="Grupo Centenario">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762994/CONSORCIO-INTI-PUNKU_mzsvaa.png" alt="Consorcio Inti Punku">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762992/ALIEX-LOGO_bochkj.png" alt="Aliex">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762991/FALABELLA-LOGO_o3xim6.png" alt="Falabella">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762989/ALMACENES-DEL-PERU_ntgwr8.png" alt="Almacenes del Perú">
                        </div>
                        
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763006/YASISA-LOGO_lu66ww.png" alt="Yasisa">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763005/TOTTUS-LOGO_zeion4.png" alt="Tottus">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763003/TEIGA-TMI_qz9r0t.png" alt="Teiga TMI">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763002/PESQUERA-DIAMANTE_lfyc2v.png" alt="Pesquera Diamante">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755763001/PESQUERA-CENTINELA_pnbz1i.png" alt="Pesquera Centinela">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762999/MODASA-LOGO_iyy10x.png" alt="Modasa">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762998/LIMA-EXPRESA-LOGO_haohgq.png" alt="Lima Expresa">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762996/JOCKEY-PLAZA-LOGO_rvhdbm.png" alt="Jockey Plaza">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762995/GRUPO-CENTENARIO_auwrrq.png" alt="Grupo Centenario">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762994/CONSORCIO-INTI-PUNKU_mzsvaa.png" alt="Consorcio Inti Punku">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762992/ALIEX-LOGO_bochkj.png" alt="Aliex">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762991/FALABELLA-LOGO_o3xim6.png" alt="Falabella">
                        </div>
                        <div class="logo-cliente">
                            <img src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755762989/ALMACENES-DEL-PERU_ntgwr8.png" alt="Almacenes del Perú">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección Marcas -->
        <section class="seccion-marcas">
            <div class="contenedor">
                <div class="marcas-contenedor">
                    <div class="circulo-azul circulo-marcas"></div>
                    <h2>Trabajamos con las mejores <span>marcas.</span></h2>
                    <div class="logos-marcas">
                        <img class="logo-marca marca-1" src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755849245/Pentair_Logo_uvjmnn.jpg" alt="PENTAIR">
                        <img class="logo-marca marca-2" src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755849244/Pedrollo-Loinsa_ajgcse.png" alt="PEDROLLO">
                        <img class="logo-marca marca-3" src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755849244/luise_lylm9r.jpg" alt="LUXSE">
                        <img class="logo-marca marca-4" src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755849243/Oroflex-Well-logo_fxkn99.png" alt="OROFLEX">
                        <img class="logo-marca marca-5" src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755849243/itap-logo_iwnja6.webp" alt="ITAP">
                        <img class="logo-marca marca-6" src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1755849243/Emaux-600X240_hwgkon.png" alt="EMAUX">
                        <img class="logo-marca marca-7" src="https://res.cloudinary.com/dg7wvqxcv/image/upload/v1756023749/pentax_3_yug6xu.png" alt="PENTAX">
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


