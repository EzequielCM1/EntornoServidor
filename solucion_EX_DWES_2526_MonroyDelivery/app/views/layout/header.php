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
    <title>Examen PHP</title>
    <base href="<?= BASE_URL; ?>">
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>

    <!-- CABECERA (Menú superior estático) -->
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <span class="logo-icon">⚙️</span> Título
            </div>

            <nav class="nav-menu">
                <a href=".">📋 Dashboard</a> 
                <a href="logout" class="salir">🚪 Salir</a>
            </nav>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL-->
    <main class="main-content">