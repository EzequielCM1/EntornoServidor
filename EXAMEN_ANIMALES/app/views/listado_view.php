<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalvaVidas — Panel de Control</title>
    <base href="<?= BASE_URL ?>">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Ejemplos estáticos para previsualizar: -->
    <!-- FLASH MESSAGE (credenciales incorrectas, sesión expirada, etc.) -->
    <!-- <div class="flash ok"><span class="flash-icono">✔</span> Ejemplo de mensaje flash de éxito</div> -->
    <!-- <div class="flash error"><span class="flash-icono">✖</span> No se pudo completar la acción.</div>  -->
    <!-- <div class="flash aviso"><span class="flash-icono">⚡</span> Thor necesita atención urgente.</div>  -->
     <?php if (isset($mensajeFlash)) : ?>
        <div class="flash <?= $mensajeFlash['clase'] ?>">
            <span class="flash-icono">
                <?= $mensajeFlash['icono'] ?> </span>
            <?= $mensajeFlash['mensaje'] ?>
        </div>
    <?php endif; ?>

    <!-- HEADER -->
    <header class="header-nav">
        <div class="wrapper header-inner">
            <div class="logo">
                <div class="logo-paw">🐾</div>
                <span class="logo-text">Salva<em>Vidas</em></span>
            </div>

            <nav class="nav-links">
                <a href="listado_view.php" class="nav-link activo">Panel de Control</a>
                <!-- ### enlaces NUEVOS ### -->
                <a href="adopcion" class="nav-link">Centro de Adopción</a>
                <a href="ingreso_view.php" class="nav-link">Nuevo Ingreso</a>
                <!-- ### fin enlaces NUEVOS ### -->
            </nav>

            <div class="header-user">
                <!-- Aquí mostrar nombre del usuario desde la sesión -->
                <span class="user-text">Bienvenido, <strong><?= $usuario  ?></strong></span>
                <!-- Botón para cerrar sesión -->
                <a href="logout" class="btn-salir">Cerrar Sesión</a>
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
                    <!-- ### panel NUEVO del examen ### -->
                    <p class="acciones-label">Acciones para toda la camada</p>
                    <div class="acciones-lista">
                        <form method="POST" action="accion/dormir">
                            <button name="accion" class="btn-accion btn-dormir">
                                <span class="btn-emoji">💤</span>
                                <span>
                                    Hora de Dormir
                                    <span class="sub">Reposo nocturno para todos</span>
                                </span>
                            </button>
                        </form>
                        <form method="POST" action="accion/pasear">
                            <button name="accion" class="btn-accion btn-pasear">
                                <span class="btn-emoji">🌳</span>
                                <span>
                                    Salida al Parque
                                    <span class="sub">Ejercicio y socialización</span>
                                </span>
                            </button>
                        </form>
                    </div>
                    <!-- ### fin panel NUEVO del examen ### -->
                </div>

                <div class="hero-mini-stats">
                    <!-- ##### calćulos NUEVO a implementar en el examen ##### -->
                    <div class="mini-stat">
                        <div class="mini-stat-num">3</div>
                        <div class="mini-stat-txt">Animales al cuidado</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-num">1</div>
                        <div class="mini-stat-txt">Necesita atención urgente</div>
                    </div>
                    <!-- ##### fin calćulos NUEVO a implementar en el examen ##### -->
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
                <!-- GATO DE EJEMPLO -->
                 <?php if (empty($animales)) : ?>
                    <div class="empty-state">
                        <div class="empty-icon">🐾</div>
                        <h3 class="empty-title">El refugio está vacío</h3>
                        <p class="empty-text">
                            Parece que ahora mismo no tenemos ningún compañero buscando hogar.
                            ¡Vuelve a consultar más tarde!
                        </p>
                    </div>
                <?php else : ?>
                    <?php foreach ($animales as $animal) : ?>
                <article class="card card-grande">
                    <div class="card-img-box">
                        <img src="img/<?= $animal['imagen'] ?>" alt="<?= $animal['nombre'] ?>" class="card-img"> <!--sustituir por la imagen del animal, alt nombre del animal-->
                        <?php if($animal['especie'] == "canino"){
                            $emoji= "🐶";
                        }else if($animal['especie'] == "felino"){
                            $emoji= "🐱";
                            }else{
                                $emoji= ""; 
                            }
                        ?>
                        <span class="badge badge-especie"><?= $emoji ?> <?= $animal['especie'] ?></span><!--sustituir por la especie e ICONO del ANIMAL-->
                        <!-- #### NUEVO este elemento se muestra cuando el animal necesita cuidado: Energía o Higiene < 30% #### -->
                         <?php if($animal['higiene']<30 || $animal['energia']<30) :?>
                        <span class="badge badge-alerta">⚠ Necesita cuidado</span>
                        <?php endif; ?>
                        <!-- ### fin NUEVO ###-->
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                                <h3 class="card-nombre"><?= $animal['nombre'] ?></h3> <!--sustituir por el nombre-->
                            <div class="card-datos">
                                <span class="dato-pill">
                                    <span class="dato-icono">🎂</span>
                                    <span class="dato-valor"><?= $animal['edad'] ?> años</span> <!--sustituir por la edad-->
                                </span>
                                <span class="dato-pill">
                                    <span class="dato-icono">⚖️</span>
                                    <span class="dato-valor"><?= $animal['peso'] ?> kg</span> <!--sustituir por el peso-->
                                </span>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">⚡ Energía</span>
                                    <span class="stat-val"><?= $animal['energia'] ?>%</span><!-- ### sustituir por el nivel de ENERGIA ### -->
                                </div>
                                <div class="track">
                                    <div class="fill fill-e" style="width:<?= $animal['energia'] ?>%"></div><!-- ### sustituir por el nivel de ENERGIA ### -->
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">🧼 Higiene</span>
                                    <span class="stat-val"><?= $animal['higiene'] ?>%</span><!-- ### sustituir por el nivel de HIGIENE ### -->
                                </div>
                                <div class="track">
                                    <div class="fill fill-h" style="width:<?= $animal['higiene'] ?>%"></div><!-- ### sustituir por el nivel de HIGIENE ### -->
                                </div>
                            </div>
                        </div>
                        <div class="card-btns">
                            <form method="POST" action="animal/<?= $animal['id'] ?>/alimentar" class="contents">
                                <button name="accion" value="alimentar" class="btn-c alimentar">🥣 Alimentar</button>
                            </form>
                            <form method="POST" action="animal/<?= $animal['id'] ?>/limpiar" class="contents">
                                <button name="accion" value="limpiar" class="btn-c limpiar">🧼 Limpiar</button>
                            </form>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
                <article class="card card-grande">
                    <div class="card-img-box">
                        <img src="img/gatos.jpg" alt="Nombre del gato" class="card-img"> <!--sustituir por la imagen del animal, alt nombre del animal-->
                        <span class="badge badge-especie">🐱 Especie del gato</span><!--sustituir por la especie e ICONO del ANIMAL-->
                        <!-- #### NUEVO este elemento se muestra cuando el animal necesita cuidado: Energía o Higiene < 30% #### -->
                        <span class="badge badge-alerta">⚠ Necesita cuidado</span>
                        <!-- ### fin NUEVO ###-->
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                            <h3 class="card-nombre">Nombre</h3><!--sustituir por el nombre-->
                            <div class="card-datos">
                                <span class="dato-pill">
                                    <span class="dato-icono">🎂</span>
                                    <span class="dato-valor">1 años</span><!--sustituir por la edad-->
                                </span>
                                <span class="dato-pill">
                                    <span class="dato-icono">⚖️</span>
                                    <span class="dato-valor">2.90 kg</span><!--sustituir por el peso-->
                                </span>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">⚡ Energía</span>
                                    <span class="stat-val">75%</span><!-- ### sustituir por el nivel de ENERGIA ### -->
                                </div>
                                <div class="track">
                                    <div class="fill fill-e" style="width:75%"></div><!-- ### sustituir por el nivel de ENERGIA ### -->
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">🧼 Higiene</span>
                                    <span class="stat-val">60%</span><!-- ### sustituir por el nivel de HIGIENE ### -->
                                </div>
                                <div class="track">
                                    <div class="fill fill-h" style="width:60%"></div><!-- ### sustituir por el nivel de HIGIENE ### -->
                                </div>
                            </div>
                        </div>
                        <!-- ### NUEVO BOTONES a implementar en el examen ### -->
                        <div class="card-btns">
                            <form method="POST" action="animal/1/alimentar" class="contents">
                                <button name="accion" value="alimentar" class="btn-c alimentar">🥣 Alimentar</button>
                            </form>
                            <form method="POST" action="animal/1/limpiar" class="contents">
                                <button name="accion" value="limpiar" class="btn-c limpiar">🧼 Limpiar</button>
                            </form>
                        </div>
                        <!-- fin ### NUEVO BOTONES a implementar en el examen ### -->

                    </div>
                </article>

                <!-- PERRO DE EJEMPLO -->
                <article class="card card-grande">
                    <div class="card-img-box">
                        <img src="img/perros.jpg" alt="Nombre del perro" class="card-img">
                        <span class="badge badge-especie">🐶 Especie del perro</span>
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                            <h3 class="card-nombre">Nombre</h3>
                            <div class="card-datos">
                                <span class="dato-pill">
                                    <span class="dato-icono">🎂</span>
                                    <span class="dato-valor">2 años</span>
                                </span>
                                <span class="dato-pill">
                                    <span class="dato-icono">⚖️</span>
                                    <span class="dato-valor">15.30 kg</span>
                                </span>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">⚡ Energía</span>
                                    <span class="stat-val">30%</span>
                                </div>
                                <div class="track">
                                    <div class="fill fill-e" style="width:30%"></div>
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">🧼 Higiene</span>
                                    <span class="stat-val">57%</span>
                                </div>
                                <div class="track">
                                    <div class="fill fill-h" style="width:57%"></div>
                                </div>
                            </div>
                        </div>
                        <!-- ### NUEVO BOTONES a implementar en el examen ### -->
                        <div class="card-btns">
                            <form method="POST" action="animal/2/alimentar" class="contents">
                                <button name="accion" value="alimentar" class="btn-c alimentar">🥣 Alimentar</button>
                            </form>
                            <form method="POST" action="animal/2/limpiar" class="contents">
                                <button name="accion" value="limpiar" class="btn-c limpiar">🧼 Limpiar</button>
                            </form>
                        </div>
                        <!-- fin ### NUEVO BOTONES a implementar en el examen ### -->
                    </div>
                </article>
                <!-- OTRO ANIMAL DE EJEMPLO -->
                <article class="card card-grande">
                    <div class="card-img-box">
                        <img src="img/otros.jpg" alt="Nombre del animal" class="card-img">
                        <span class="badge badge-especie">Especie del animal</span>
                        <!-- #### NUEVO este elemento se muestra cuando el animal necesita cuidado: Energía o Higiene < 30% #### -->
                        <span class="badge badge-alerta">⚠ Necesita cuidado</span>
                    </div>
                    <div class="card-body">
                        <div class="card-header-row">
                            <h3 class="card-nombre">Nombre</h3>
                            <div class="card-datos">
                                <span class="dato-pill">
                                    <span class="dato-icono">🎂</span>
                                    <span class="dato-valor">4 años</span>
                                </span>
                                <span class="dato-pill">
                                    <span class="dato-icono">⚖️</span>
                                    <span class="dato-valor">1.80 kg</span>
                                </span>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">⚡ Energía</span>
                                    <span class="stat-val">90%</span>
                                </div>
                                <div class="track">
                                    <div class="fill fill-e" style="width:90%"></div>
                                </div>
                            </div>
                            <div class="stat">
                                <div class="stat-row">
                                    <span class="stat-label">🧼 Higiene</span>
                                    <span class="stat-val">15%</span>
                                </div>
                                <div class="track">
                                    <div class="fill fill-h" style="width:15%"></div>
                                </div>
                            </div>
                        </div>
                        <!-- ### NUEVO BOTONES a implementar en el examen ### -->
                        <div class="card-btns">
                            <form method="POST" action="animal/3/alimentar" class="contents">
                                <button name="accion" value="alimentar" class="btn-c alimentar">🥣 Alimentar</button>
                            </form>
                            <form method="POST" action="animal/3/limpiar" class="contents">
                                <button name="accion" value="limpiar" class="btn-c limpiar">🧼 Limpiar</button>
                            </form>
                        </div>
                        <!-- fin ### NUEVO BOTONES a implementar en el examen ### -->
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