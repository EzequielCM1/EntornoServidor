<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaVidas — Panel de Control</title>
    <!-- <base href=""> -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!--
        EJERCICIOS A IMPLEMENTAR:
        1. Proteger esta página (solo usuarios autenticados pueden acceder)
        2. Consultar animales de la BBDD
        3. Mostrar cards con los datos de cada animal
    -->
    <!-- FLASH MESSAGE (credenciales incorrectas, sesión expirada, etc.) -->
    <div class="flash ok"> <span class="flash-icono">✔</span> El perro Thor ha sido eliminado correctamente.</div>
    <!-- <div class="flash error"><span class="flash-icono">✖</span> No se pudo completar la acción.</div>  -->
    <!-- <div class="flash aviso"><span class="flash-icono">⚡</span> El animal Thor no existe en la base de datos.</div>  -->

    <!-- HEADER -->
    <header class="header-nav">
        <div class="wrapper header-inner">
            <div class="logo">
                <div class="logo-paw">🐾</div>
                <span class="logo-text">Salva<em>Vidas</em></span>
            </div>

            <nav class="nav-links">
                <a href="listado_view.php" class="nav-link activo">Panel de Control</a>
                <!-- enlaces que se implementarán en el examen -->
                <a href="#" class="nav-link">Enlace1</a>
                <a href="#" class="nav-link">Enlace2</a>
            </nav>

            <div class="header-user">
                <!-- Aquí mostrar nombre del usuario desde la sesión -->
                <span class="user-text">Bienvenido, <strong>USUARIO</strong></span>
                <!-- Botón para cerrar sesión -->
                <a href="#" class="btn-salir">Cerrar Sesión</a>
            </div>

        </div>
    </header>

    <main class="wrapper">

        <!-- HERO -->
        <section class="hero">
            <div class="hero-foto">
                <span class="hero-tag">🐾 Refugio activo</span>
                <h1 class="hero-h1">Cada animal<br>merece una<br><em>historia bonita.</em></h1>
                <p class="hero-sub">Cuida, alimenta y prepara a tus rescatados para que encuentren el hogar que merecen.</p>
            </div>

            <div class="hero-panel">
                <div>
                    <!-- panel que se actualizará en el examen -->
                    <p class="acciones-label">##Título##</p>
                    <div class="acciones-lista">
                        <form method="POST" action="#">
                            <button name="accion" class="btn-accion btn-accion1" disabled>
                                <span>
                                    ## instrucciones 1 ##
                                </span>
                            </button>
                        </form>
                        <form method="POST" action="#">
                            <button name="accion" class="btn-accion btn-accion2" disabled>
                                <span>
                                    ## instrucciones 2 ##
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="hero-mini-stats">
                    <!-- caćulos a implementar en el examen -->
                    <div class="mini-stat">
                        <div class="mini-stat-num">## X ##</div>
                        <div class="mini-stat-txt">## Info 1 ##</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-num">## Y ##</div>
                        <div class="mini-stat-txt">## Info2 ##</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ANIMALES -->
        <section>
            <div class="seccion-head">
                <h2>Estado de los Animales</h2>
            </div>

            <div class="grid-mascotas">
                <!-- aquí se mostrarán los animales de la BBDD -->
                <!-- EJEMPLO 1: gato -->
                <article class="card card-grande">
                    <div class="card-img-box"> <!--sustituir por la imagen del animal, alt nombre del animal-->
                        <img src="img/gatos.jpg" alt="Nombre del gato" class="card-img">
                        <span class="badge badge-especie">Especie del gato</span> <!--sustituir por la especie-->
                        <!-- implementaremos aquí algo en el examen -->
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                            <h3 class="card-nombre">Nombre</h3> <!--sustituir por el nombre-->
                            <div class="card-datos">
                                <span class="dato-pill">
                                    <span class="dato-icono">🎂</span>
                                    <span class="dato-valor">X años</span> <!--sustituir por la edad-->
                                </span>
                                <span class="dato-pill">
                                    <span class="dato-icono">⚖️</span>
                                    <span class="dato-valor">X.X kg</span> <!--sustituir por el peso-->
                                </span>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">📚 Adiestramiento</span>
                                    <span class="stat-val">1/10</span> <!--sustituir por el nivel de adiestramiento-->
                                </div>
                                <div class="track">
                                    <div class="fill fill-x" style="width:10%"></div> <!--sustituir por el nivel de adiestramiento x 10-->
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">📋 Puntos de Expediente</span>
                                    <span class="stat-val">67/100</span> <!--sustituir por los puntos de expediente-->
                                </div>
                                <div class="track">
                                    <div class="fill fill-y" style="width:67%"></div> <!--sustituir por los puntos de expediente-->
                                </div>
                            </div>
                        </div>
                        <!-- BOTONES a implementar en el examen -->
                        <div class="card-btns">
                            <form method="POST" action="#" class="contents">
                                <button name="accion" value="accion1" class="btn-c btn-n" disabled>## Ver ficha ##</button> <!--sustituir en el examen-->
                            </form>
                            <form method="POST" action="#" class="contents">
                                <button name="accion" value="accion2" class="btn-c btn-m" disabled>## Acción 1 ##</button> <!--sustituir en el examen-->
                            </form>
                        </div>
                    </div>
                </article>

                <!-- EJEMPLO 2: perro-->
                <article class="card card-grande">
                    <div class="card-img-box">
                        <img src="img/perros.jpg" alt="Nombre del perro" class="card-img"> <!--sustituir por la imagen-->
                        <span class="badge badge-especie">Especie del perro</span> <!--sustituir por la especie-->
                        <!-- implementaremos aquí algo en el examen -->
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                            <h3 class="card-nombre">Nombre</h3> <!--sustituir por el nombre-->
                            <div class="card-datos">
                                <span class="dato-pill">
                                    <span class="dato-icono">🎂</span>
                                    <span class="dato-valor">X años</span> <!--sustituir por la edad-->
                                </span>
                                <span class="dato-pill">
                                    <span class="dato-icono">⚖️</span>
                                    <span class="dato-valor">X.X kg</span> <!--sustituir por el peso-->
                                </span>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">📚 Adiestramiento</span>
                                    <span class="stat-val">5/10</span> <!--sustituir por el nivel de adiestramiento-->
                                </div>
                                <div class="track">
                                    <div class="fill fill-x" style="width:50%"></div> <!--sustituir por el nivel de adiestramiento-->
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">📋 Puntos de Expediente</span>
                                    <span class="stat-val">27/100</span> <!--sustituir por los puntos de expediente-->
                                </div>
                                <div class="track">
                                    <div class="fill fill-y" style="width:27%"></div> <!--sustituir por los puntos de expediente-->
                                </div>
                            </div>
                        </div>
                        <!-- BOTONES A IMPLEMENTAR EN EL EXAMEN -->
                        <div class="card-btns">
                            <form method="POST" action="#" class="contents">
                                <button name="accion" value="accion1" class="btn-c btn-n" disabled>## Ver ficha ##</button> <!--sustituir en el examen-->
                            </form>
                            <form method="POST" action="#" class="contents">
                                <button name="accion" value="accion2" class="btn-c btn-m" disabled>## Acción 1 ##</button> <!--sustituir en el examen-->
                            </form>
                        </div>
                    </div>
                </article>

                <!-- EJEMPLO 3: animal -->
                <article class="card card-grande">
                    <div class="card-img-box">
                        <img src="img/otros.jpg" alt="Nombre del animal" class="card-img"> <!--sustituir por la imagen-->
                        <span class="badge badge-especie">Especie del animal</span> <!--sustituir por la especie-->
                        <!-- implementaremos aquí algo en el examen -->
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                            <h3 class="card-nombre">Nombre</h3> <!--sustituir por el nombre-->
                            <div class="card-datos">
                                <span class="dato-pill">
                                    <span class="dato-icono">🎂</span>
                                    <span class="dato-valor">X años</span> <!--sustituir por la edad-->
                                </span>
                                <span class="dato-pill">
                                    <span class="dato-icono">⚖️</span>
                                    <span class="dato-valor">X.X kg</span> <!--sustituir por el peso-->
                                </span>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">📚 Nivel de Adiestramiento</span>
                                    <span class="stat-val">2/10</span> <!--sustituir por el nivel de adiestramiento-->
                                </div>
                                <div class="track">
                                    <div class="fill fill-x" style="width:20%"></div> <!--sustituir por el nivel de adiestramiento-->
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">📋 Puntos de Expediente</span>
                                    <span class="stat-val">45/100</span> <!--sustituir por los puntos de expediente-->
                                </div>
                                <div class="track">
                                    <div class="fill fill-y" style="width:45%"></div> <!--sustituir por los puntos de expediente-->
                                </div>
                            </div>
                        </div>
                        <div class="card-btns">
                            <form method="POST" action="#" class="contents">
                                <button name="accion" value="accion1" class="btn-c btn-n" disabled>## Ver ficha ##</button> <!--sustituir en el examen-->
                            </form>
                            <form method="POST" action="#" class="contents">
                                <button name="accion" value="accion2" class="btn-c btn-m" disabled>## Acción 1 ##</button> <!--sustituir en el examen-->
                            </form>
                        </div>
                    </div>
                </article>
                <!-- SI NO HAY ANIMALES mostrar esta caja-->
                <!-- <div class="empty-state">
                    <div class="empty-icon">🐾</div>
                    <h3 class="empty-title">El refugio está vacío</h3>
                    <p class="empty-text">
                        Parece que ahora mismo no tenemos ningún compañero buscando hogar.
                        ¡Vuelve a consultar más tarde!
                    </p>
                </div> -->
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; 2026 <span class="logo-text sm">Salva<em>Vidas</em></span> by PLluyot — Hecho con ❤️ para los que no tienen voz.</p>
    </footer>

</body>

</html>