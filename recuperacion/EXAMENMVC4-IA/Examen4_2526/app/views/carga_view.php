<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alcalá Delivery - Gestión de Carga</title>
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
            <?php if (!empty($mensaje)): ?>
                <div class="flash-message <?= $tipo_mensaje ?>">
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
                            <span class="summary-value"><?= $vehiculo['nombre'] ?> (<?= $vehiculo['matricula'] ?>)</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">⚖️</span>
                        <div>
                            <span class="summary-label">Carga (Actual / Máxima):</span>
                            <span class="summary-value"><?= $peso_actual ?? 0 ?> / <?= $vehiculo['carga_maxima'] ?> kg</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">📦</span>
                        <div>
                            <span class="summary-label">Volumen (Actual / Máximo):</span>
                            <span class="summary-value"><?= $volumen_actual ?? 0 ?> / <?= $vehiculo['volumen_maximo'] ?> m³</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Botones de Acción -->
            <section class="action-buttons">
                <form action="calcular-carga" method="POST">
                    <button type="submit" class="btn btn-secondary" <?= empty($paquetes) ? 'disabled' : '' ?>>
                        🔄 Calcular Carga Óptima
                    </button>
                </form>
                <form action="confirmar-envio" method="POST">
                    <button type="submit" class="btn btn-primary" <?= $btn_confirmar ?? 'disabled' ?>>
                        ✅ Confirmar Envío
                    </button>
                </form>
            </section>

            <!-- Tabla de Paquetes -->
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
                                <?php
                                $status_class = "package-pending";
                                $badge_class = "status-pending";
                                $modo = $paquete['modo'] ?? 'Pendiente';
                                
                                if ($modo == 'Aceptado') {
                                    $status_class = "package-accepted";
                                    $badge_class = "status-accepted";
                                } elseif ($modo == 'Rechazado') {
                                    $status_class = "package-rejected";
                                    $badge_class = "status-rejected";
                                }

                                $priority_class = "priority-low";
                                if ($paquete['prioridad'] == 'Alta') $priority_class = "priority-high";
                                if ($paquete['prioridad'] == 'Media') $priority_class = "priority-medium";
                                ?>
                                <tr class="<?= $status_class ?>">
                                    <td><?= $paquete['codigo'] ?></td>
                                    <td><?= $paquete['destino'] ?></td>
                                    <td><?= $paquete['peso'] ?></td>
                                    <td><?= $paquete['volumen'] ?></td>
                                    <td><span class="priority <?= $priority_class ?>"><?= $paquete['prioridad'] ?></span></td>
                                    <td><span class="status-badge <?= $badge_class ?>"><?= $modo ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <!-- Pie de Página Común -->
    <footer class="main-footer">
        <div class="footer-container">
            <p>© 2025 Monroy Delivery - by P.Lluyot</p>
        </div>
    </footer>


</body>

</html>