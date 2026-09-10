<?php
/**
 * P.Lluyot-2025
 */
?>
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

            <nav class="main-nav">
                <a href="." class="nav-link active">Vehículos</a>
                <a href="carga" class="nav-link">Gestión de Carga</a>
            </nav>

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
            <?php if (isset($mensaje) && $mensaje != ''): ?>
                <div class="flash-message flash-success">
                    <?= $mensaje; ?>
                </div>
            <?php endif; ?>

            <section class="page-header">
                <h2>Gestión de Vehículos</h2>
                <p class="page-description">Seleccione un vehículo disponible para asignar la carga</p>
            </section>

            <!-- Grid de Vehículos -->
            <section class="vehicles-grid">
                <?php if (!isset($vehiculos) || count($vehiculos) == 0): ?>
                    <h1>No hay vehículos disponibles</h1>
                <?php endif; ?>
                <?php foreach ($vehiculos as $vehiculo): ?>
                    <!-- Card Vehículo 1 -->
                    <article class="vehicle-card">
                        <div class="vehicle-image">
                            <img src="./img/vehiculos/<?= $vehiculo['imagen']; ?>?>" alt="<?= $vehiculo['nombre']; ?>">
                            <?php switch ($vehiculo['estado']) {
                                case "Disponible":
                                    $clase = "status-available";
                                    break;
                                case "En Ruta":
                                    $clase = "status-busy";
                                    break;
                                case "Mantenimiento":
                                    $clase = "status-maintenance";
                                    break;
                                default:
                                    $clase = "";
                            } ?>
                            <span class="vehicle-status <?= $clase; ?>"><?= $vehiculo['estado']; ?></span>
                        </div>
                        <div class="vehicle-info">
                            <h3 class="vehicle-name"><?= $vehiculo['nombre']; ?></h3>
                            <p class="vehicle-plate">🚗 Matrícula: <strong><?= $vehiculo['matricula']; ?></strong></p>
                            <div class="vehicle-specs">
                                <div class="spec-item">
                                    <span class="spec-icon">⚖️</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Carga Máx:</span>
                                        <span class="spec-value"><?= $vehiculo['carga_maxima']; ?> kg</span>
                                    </div>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-icon">📦</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Volumen Máx:</span>
                                        <span class="spec-value"><?= $vehiculo['volumen_maximo']; ?> m³</span>
                                    </div>

                                </div>
                                <div class="spec-item">
                                    <span class="spec-icon">⛽</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Combustible:</span>
                                        <span class="spec-value"><?= $vehiculo['combustible']; ?></span>
                                    </div>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-icon">🛣️</span>
                                    <div class="spec-content">
                                        <span class="spec-label">Kilometraje:</span>
                                        <span class="spec-value"><?= $vehiculo['km']; ?> km</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($vehiculo['estado'] == 'Disponible'): ?>

                            <div class="vehicle-actions">
                                <form action="asignar-vehiculo" method="POST">
                                    <input type="hidden" name="id_vehiculo" value="<?= $vehiculo['id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        📋 Asignar Carga
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>

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