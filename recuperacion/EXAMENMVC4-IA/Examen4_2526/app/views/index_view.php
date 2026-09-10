<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monroy Delivery - Gestión de Vehículos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Cabecera Común -->
    <header class="main-header">
        <div class="header-container">
            <div class="header-logo">
                <h1>🚚 Monroy Delivery</h1>
            </div>
            <!-- Actualizar los enlaces del menú -->
            <nav class="main-nav">
                <a href="." class="nav-link active">Vehículos</a>
                <a href="carga" class="nav-link">Gestión de Carga</a>
            </nav>
            <!-- información del usuario -->
            <div class="header-user">
                <div class="user-info">
                    <span class="user-name">👤 <?= $empleado['nombre'] ?? 'empleado'; ?> <?= $empleado['apellidos']??''?></span>
                    <span class="user-role">(<?= $empleado['rol'] ?? '-'; ?>)</span>
                </div>
                <a href="logout" class="btn-logout">🚪 Salir</a>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="main-content">
        <div class="content-container">
            <!-- Mensaje Flash -->
             <?php if(!empty($mensaje)): ?>
            <div class="flash-message <?= $tipo_mensaje ?>">
                <?= $mensaje; ?>
            </div>
            <?php endif; ?>

            <section class="page-header">
                <h2>Gestión de Vehículos</h2>
                <p class="page-description">Seleccione un vehículo disponible para asignar la carga</p>
            </section>

            <!-- Grid de Vehículos -->
            <section class="vehicles-grid">
                <!-- Mostrar cuando no hay vehículos -->
                <!-- <h1>No hay vehículos disponibles</h1> -->
                <?php if(empty($datos)): ?>
                    <h1>No hay vehículos disponibles</h1>
                <?php else: ?>
                <!-- Aqui las cards -->
                <?php foreach ($datos as $coche): ?>
                    <?php
                    // conseguir el estilo del estado 
                    $estado = $coche['estado'];
                    $estilo = "";
                    if ($estado == "Disponible") {
                        $estilo = "status-available";
                    }
                    if ($estado == "En Ruta") {
                        $estilo = "status-busy";
                    }
                    if ($estado == "Mantenimiento") {
                        $estilo = "status-maintenance";
                    }
                    ?>
                    <article class="vehicle-card">
                        <div class="vehicle-image">
                            <img src="./img/vehiculos/<?= $coche['imagen'] ?>" alt="nombre del vehículo">
                            <span class="vehicle-status <?= $estilo ?>"><?= $coche['estado'] ?></span>
                        </div>
                        <div class="vehicle-info">
                            <h3 class="vehicle-name"><?= $coche["nombre"] ?></h3>
                            <p class="vehicle-plate">🚗 Matrícula: <strong><?= $coche["matricula"] ?></strong></p>
                            <div class="vehicle-specs">
                                <div class="spec-item">
                                    <span class="spec-icon">⚖️</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Carga Máx:</span>
                                        <span class="spec-value"><?= $coche["carga_maxima"] ?> kg</span>
                                    </div>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-icon">📦</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Volumen Máx:</span>
                                        <span class="spec-value"><?= $coche["volumen_maximo"] ?> m³</span>
                                    </div>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-icon">⛽</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Combustible:</span>
                                        <span class="spec-value"><?= $coche["combustible"] ?></span>
                                    </div>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-icon">🛣️</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Kilometraje:</span>
                                        <span class="spec-value"><?= $coche["km"] ?> km</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- acciones del vehículo -->
                        <div class="vehicle-actions">
                            <?php if ($coche['estado'] == 'Disponible'): ?>
                                <form action="asignar-vehiculo" method="POST">
                                    <input type="hidden" name="id_vehiculo" value="<?= $coche['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        🚛 Asignar Vehículo
                                    </button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-block" disabled>
                                    🚫 No Disponible
                                </button>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php endif; ?>

            </section>
        </div>
    </main>
    <!-- Pie de Página Común -->
    <footer class="main-footer">
        <div class="footer-container">
            <p>&copy; 2025 Monroy Delivery - by P.Lluyot</p>
        </div>
    </footer>
</body>

</html>