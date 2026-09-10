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
                            <span class="summary-value"><?= $vehiculo['nombre'] ?> <?= $vehiculo['matricula'] ?></span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">⚖️</span>
                        <div>
                            <span class="summary-label">Carga (Actual / Máxima):</span>
                            <span class="summary-value">0 / <?= $vehiculo['carga_maxima'] ?> kg</span>
                        </div>
                    </div>
                    <div class="summary-item">
                        <span class="summary-icon">📦</span>
                        <div>
                            <span class="summary-label">Volumen (Actual / Máximo):</span>
                            <span class="summary-value">0 / <?= $vehiculo['volumen_maximo'] ?> m³</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Botones de Acción -->
            <section class="action-buttons">
                <form action="calcular-carga" method="POST">
                    <button type="submit" class="btn btn-secondary">
                        🔄 Calcular Carga Óptima
                    </button>
                </form>
                <form action="confirmar-envio" method="POST">
                    <button type="submit" class="btn btn-primary" disabled="">
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
                            <tr class="package-pending">
                                <td>P01</td>
                                <td>Dirección del paquete 1</td>
                                <td>100.00</td>
                                <td>5.50</td>
                                <td><span class="priority priority-high">Alta</span></td>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                            </tr>
                            <tr class="package-pending">
                                <td>P02</td>
                                <td>Dirección del paquete 2</td>
                                <td>50.00</td>
                                <td>0.50</td>
                                <td><span class="priority priority-high">Alta</span></td>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                            </tr>
                            <tr class="package-pending">
                                <td>P03</td>
                                <td>Dirección del paquete 3</td>
                                <td>60.00</td>
                                <td>0.80</td>
                                <td><span class="priority priority-medium">Media</span></td>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                            </tr>
                            <tr class="package-pending">
                                <td>P04</td>
                                <td>Dirección del paquete 4</td>
                                <td>70.00</td>
                                <td>3.00</td>
                                <td><span class="priority priority-low">Baja</span></td>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                            </tr>
                            <tr class="package-pending">
                                <td>P05</td>
                                <td>Dirección del paquete 5</td>
                                <td>5.00</td>
                                <td>0.35</td>
                                <td><span class="priority priority-low">Baja</span></td>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                            </tr>
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