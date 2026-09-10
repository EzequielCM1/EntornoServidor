<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Adopción — SalvaVidas</title>
    <base href="<?= BASE_URL ?>">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Ejemplos estáticos para previsualizar: -->
    <!-- FLASH MESSAGE (credenciales incorrectas, sesión expirada, etc.) -->
    <!-- <div class="flash ok"><span class="flash-icono">✔</span> Ejemplo de mensaje flash de éxito</div> -->
    <!-- <div class="flash error"><span class="flash-icono">✖</span> No se pudo completar la acción.</div> -->
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
                <a href="" class="nav-link">Panel de Control</a>
                <!-- ### enlaces NUEVOS ### -->
                <a href="adopcion" class="nav-link activo">Centro de Adopción</a>
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

        <!-- CABECERA CON FOTO -->
        <div class="adopcion-banda">
            <h1 class="adopcion-banda-titulo">Hogares en <em>espera.</em></h1>
            <p class="adopcion-banda-sub">Solo los animales con salud y energía óptima están listos para comenzar su nueva vida.</p>
        </div>

        <!-- Cabecera de sección con contador -->
        <div class="seccion-head">
            <h2>Candidatos a Adopción</h2>
            <span class="num-pill"><?= count($animales) ?> registrados</span><!-- sustituir por el número de animales en_refugio=1-->
        </div>

        <!-- FICHAS HORIZONTALES -->
        <div class="adopcion-lista">

            <!-- EJEMPLO DE GATO en refugio, no adoptable porque sus características Higiene y Energía son bajas -->
            <!-- Si Energía e Higiene >=75% ponemos la clase ficha-ok, en otro caso ficha-bloqueada -->
             <?php if(empty($animales)) :?>
                <div class="empty-state">
                    <div class="empty-icon">🐾</div>
                    <h3 class="empty-title">El refugio está vacío</h3>
                    <p class="empty-text">
                        Parece que ahora mismo no tenemos ningún compañero buscando hogar.
                        ¡Vuelve a consultar más tarde!
                    </p>
                </div>
            <?php else : ?>
             <?php foreach($animales as $animal) :?>
                <?php if($animal['higiene']<=75 && $animal['higiene']<=75){
                    $habilitado = "ficha-ok" ;
                }else{
                    $habilitado = "ficha-bloqueada";
                } ?>
            <article class="ficha-animal <?= $habilitado ?>"> <!-- clases: ficha-bloqueada o ficha-ok -->
                <!-- FOTO -->
                <div class="ficha-foto">
                    <img src="img/<?= $animal['imagen'] ?>"
                        alt="<?= $animal['nombre'] ?>"><!--sustituir por el nombre y la imagen del animal-->
                </div>
                <!-- NOMBRE + ESPECIE/RAZA -->
                <div class="ficha-id">
                    <span class="ficha-nombre">
                        <?= $animal['nombre'] ?></span><!--sustituir por el nombre del animal-->
                    <span class="ficha-raza"><?= $animal['especie'] ?> · <?= $animal['raza'] ?></span>
                </div><!--sustituir la especie y raza del animal-->
                <!-- DATOS: EDAD + PESO + HIGIENE + ENERGIA-->
                <div class="ficha-datos">
                    <span class="dato-pill">
                        <span class="dato-icono">🎂</span>
                        <span class="dato-valor"><?= $animal['edad'] ?> años</span><!--sustituir por los años del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">⚖️</span>
                        <span class="dato-valor"><?= $animal['peso'] ?> kg</span><!--sustituir por el peso del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">⚡</span>
                        <span class="dato-valor"><?= $animal['energia'] ?>%</span><!--sustituir por la energía del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">🧼</span>
                        <span class="dato-valor"><?= $animal['higiene'] ?>%</span><!--sustituir por la higiene del animal-->
                    </span>
                </div>
                <!-- ACCIÓN -->
                <div class="ficha-accion">
                    <!-- PONER una opción u otra en función si se puede adoptar o no -->
                     <?php if($habilitado == "ficha-ok"): ?>
                    <form method="POST" action="animal/<?= $animal['id'] ?>/adoptar">
                        <button class="btn-adoptar">
                            Finalizar adopción
                        </button>
                    </form> 
                    <?php else: ?>
                    <span class="ficha-badge-no">En tratamiento</span>
                    <?php endif; ?>
                </div>
            </article>
                <?php endforeach; ?>
                <?php endif; ?>

            <!-- EJEMPLO DE PERRO en refugio, no adoptable porque sus características Higiene y Energía son bajas -->
            <!-- Si Energía e Higiene >=75% ponemos la clase ficha-ok, en otro caso ficha-bloqueada -->
            <article class="ficha-animal ficha-bloqueada"><!-- clases: ficha-bloqueada o ficha-ok -->
                <!-- FOTO -->
                <div class="ficha-foto">
                    <img src="img/perros.jpg"
                        alt="Nombre del animal"><!--sustituir por el nombre y la imagen del animal-->
                </div>
                <!-- NOMBRE + ESPECIE/RAZA -->
                <div class="ficha-id">
                    <span class="ficha-nombre">
                        Nombre</span>
                    <span class="ficha-raza">Canino · Raza del animal</span>
                </div>
                <!-- DATOS: EDAD + PESO + HIGIENE + ENERGIA-->
                <div class="ficha-datos">
                    <span class="dato-pill">
                        <span class="dato-icono">🎂</span>
                        <span class="dato-valor">2 años</span><!--sustituir por los años del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">⚖️</span>
                        <span class="dato-valor">5.50 kg</span><!--sustituir por el peso del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">⚡</span>
                        <span class="dato-valor">85%</span><!--sustituir por la energía del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">🧼</span>
                        <span class="dato-valor">60%</span><!--sustituir por la higiene del animal-->
                    </span>
                </div>
                <!-- ACCIÓN -->
                <div class="ficha-accion">
                    <!-- PONER una opción u otra en función si se puede adoptar o no -->
                    <!-- <form method="POST" action="animal/1/adoptar">
                        <button class="btn-adoptar">
                            Finalizar adopción
                        </button>
                    </form> -->
                    <span class="ficha-badge-no">En tratamiento</span>
                </div>
            </article>

            <!-- EJEMPLO DE OTRO animal en refugio, SI adoptable porque sus características Higiene y Energía son >=75% -->
            <!-- Si Energía e Higiene >=75% ponemos la clase ficha-ok, en otro caso ficha-bloqueada -->
            <article class="ficha-animal ficha-ok"><!-- clases: ficha-bloqueada o ficha-ok -->
                <!-- FOTO -->
                <div class="ficha-foto">
                    <img src="img/otros.jpg"
                        alt="Nomobre del animal"><!--sustituir por el nombre y la imagen del animal-->
                </div>
                <!-- NOMBRE + ESPECIE/RAZA -->
                <div class="ficha-id">
                    <span class="ficha-nombre">
                        Nombre</span>
                    <span class="ficha-raza">Otro · Raza del animal</span>
                </div>
                <!-- DATOS: EDAD + PESO + HIGIENE + ENERGIA-->
                <div class="ficha-datos">
                    <span class="dato-pill">
                        <span class="dato-icono">🎂</span>
                        <span class="dato-valor">3 años</span><!--sustituir por los años del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">⚖️</span>
                        <span class="dato-valor">3.40 kg</span><!--sustituir por el peso del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">⚡</span>
                        <span class="dato-valor">85%</span><!--sustituir por la energía del animal-->
                    </span>
                    <span class="dato-pill">
                        <span class="dato-icono">🧼</span>
                        <span class="dato-valor">75%</span><!--sustituir por la higiene del animal-->
                    </span>
                </div>
                <!-- ACCIÓN -->
                <div class="ficha-accion">
                    <!-- PONER una opción u otra en función si se puede adoptar o no -->
                    <form method="POST" action="animal/1/adoptar">
                        <button class="btn-adoptar">
                            Finalizar adopción
                        </button>
                    </form>
                    <!-- <span class="ficha-badge-no">En tratamiento</span> -->
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
    </main>

    <footer class="footer">
        <p>&copy; 2026 <span class="logo-text sm">Salva<em>Vidas</em></span> by PLluyot — Hecho con ❤️ para los que no tienen voz.</p>
    </footer>

</body>

</html>