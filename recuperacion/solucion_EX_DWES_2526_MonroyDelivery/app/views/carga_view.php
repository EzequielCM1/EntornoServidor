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
    <base href="<?= BASE_URL ?>">
    <title>Monroy Delivery - Gestión de Carga</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Cabecera Común -->
    <header class="main-header">
        <div class="header-container">
            <div class="header-logo">
                <h1>🚚 Alcalá Delivery</h1>
            </div>

            <nav class="main-nav">
                <a href="." class="nav-link">Vehículos</a>
                <a href="carga" class="nav-link active">Gestión de Carga</a>
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
                <h2>Gestión de Carga</h2>
                <p class="page-description">Optimice la carga del vehículo seleccionado</p>
            </section>

            <!-- Información del Vehículo Seleccionado -->
            <section class="selected-vehicle-info">
                <div class="vehicle-summary">
                    <div class="summary-item">
                        <span class="summary-icon">🚚</span>
                        <div>
                            <span class="summary-label">Vehículo:</span>
                            <span class="summary-value"><?= $vehiculo['nombre']; ?> (<?= $vehiculo['matricula']; ?>)</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">⚖️</span>
                        <div>
                            <span class="summary-label">Carga (Actual / Máxima):</span>
                            <span class="summary-value"><?= $peso_actual ?? 0 ?> / <?= round($vehiculo['carga_maxima'], 2); ?> kg</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">📦</span>
                        <div>
                            <span class="summary-label">Volumen (Actual / Máximo):</span>
                            <span class="summary-value"><?= $volumen_actual ?? 0; ?> / <?= round($vehiculo['volumen_maximo'], 2); ?> m³</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Botones de Acción -->
            <section class="action-buttons">
                <form action="calcular-carga" method="POST">
                    <button type="submit" class="btn btn-secondary" <?php echo (count($paquetes)==0?'disabled':''); ?>>
                        🔄 Calcular Carga Óptima
                    </button>
                </form>
                <form action="confirmar-envio" method="POST">
                    <button type="submit" class="btn btn-primary" <?php echo ($btn_confirmar ?? 'disabled'); ?>>
                        ✅ Confirmar Envío
                    </button>
                </form>
            </section>

            <!-- Tabla de Paquetes -->
            <?php if (isset($paquetes) && count($paquetes) > 0): ?>
                <section class="packages-section">
                    <h3 class="section-title">Paquetes Pendientes</h3>
                    <div class="table-responsive">
                        <table class="packages-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Destino</th>
                                    <th>Peso (kg)</th>
                                    <th>Volumen (m³)</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($paquetes as $paquete): ?>
                                    <?php switch ($paquete['prioridad'] ?? '') {
                                        case "Alta":
                                            $clase3 = "priority-high";
                                            break;
                                        case "Media":
                                            $clase3 = "priority-medium";
                                            break;
                                        default:
                                            $clase3 = "priority-low";
                                    }
                                    switch ($paquete['modo'] ?? '') {
                                        case "Aceptado":
                                            $clase1 = "package-accepted";
                                            $clase2 = "status-accepted";
                                            break;
                                        case "Rechazado":
                                            $clase1 = "package-rejected";
                                            $clase2 = "status-rejected";
                                            break;
                                        default:
                                            $clase1 = "package-pending";
                                            $clase2 = "status-pending";
                                    } ?>
                                    <tr class="<?= $clase1; ?>">
                                        <td><?= $paquete['codigo'] ?></td>
                                        <td><?= $paquete['destino'] ?></td>
                                        <td><?= $paquete['peso'] ?></td>
                                        <td><?= $paquete['volumen'] ?></td>
                                        <td><span class="priority <?= $clase3; ?>"><?= $paquete['prioridad'] ?></span></td>
                                        <td><span class="status-badge <?= $clase2; ?>"><?= $paquete['modo'] ?? 'Pendiente' ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                </section>
        </div>
    </main>

    <!-- Pie de Página Común -->
    <footer class="main-footer">
        <div class="footer-container">
            <p>&copy; 2025 Alcalá Delivery - by P.Lluyot</p>
        </div>
    </footer>
</body>

</html>