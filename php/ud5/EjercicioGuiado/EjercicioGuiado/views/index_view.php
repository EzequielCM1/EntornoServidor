<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <!-- Carga de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
            /* Fondo base claro */
            padding: 20px;
        }

        /* Estilos generales de la tarjeta para Neumorfismo */
        .card-container {
            box-shadow:
                -10px -10px 30px #ffffff,
                10px 10px 30px rgba(174, 174, 192, 0.4);
            transition: all 0.3s ease;
            background-color: white;
        }

        /* Estilo para el botón de "Insertar" */
        .btn-insert {
            transition: all 0.2s ease;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), -4px -4px 10px #ffffff;
        }

        .btn-insert:active {
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1), inset -2px -2px 5px #ffffff;
            transform: translateY(1px);
        }

        /* Estilos para las acciones (Eliminar/Actualizar) */
        .action-link {
            transition: color 0.2s ease;
            font-weight: 600;
        }

        /* Estilos para la tabla (mejoramos las celdas para que tengan un toque moderno) */
        .table-neumorphic th,
        .table-neumorphic td {
            border: none;
            /* Quitamos los bordes duros de la tabla */
        }

        .table-neumorphic th {
            background-color: #e0e6ed;
            /* Fondo suave para el encabezado */
        }

        .table-neumorphic tr:nth-child(even) {
            background-color: #f7f9fc;
            /* Rayas ligeras */
        }

        .table-neumorphic tr:hover {
            background-color: #e6edf7;
            /* Hover suave */
        }

        .mensaje {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .exito {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body class="p-4 sm:p-8">

    <!-- Contenedor principal estilo tarjeta elevada, responsive -->
    <div class="card-container p-6 sm:p-10 rounded-xl w-full max-w-7xl mx-auto min-h-screen">

        <header class="mb-8 border-b pb-4 border-gray-200">
            <h1 class="text-4xl font-extrabold text-gray-900">Gestión de Productos</h1>
        </header>

        <!-- Zona de mensajes PHP simulada -->
        <div>
            <div>
                <?php if (!empty($mensajelogin)) : ?>
                    <div class="mensaje exito">
                        <?php echo $mensajelogin; ?>
                    </div>
            </div>
        <?php elseif (isset($mensaje)): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <?= $_SESSION['rol'] ?>
        <h2 class="text-2xl font-bold text-gray-800 mt-6 mb-4">Listado de Productos</h2>

        <!-- Botón Insertar -->
        <?php if ($rol == "admin"): ?>
            <div class="insertar mb-6">
                <a href="insert.php?" class="btn-insert inline-flex items-center px-6 py-3 border border-transparent text-sm leading-4 font-bold rounded-full shadow-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Insertar uno Nuevo
                </a>
            </div>
        <?php endif; ?>

        <!-- Boton para cerrar sesion  -->
        <div class="insertar mb-6">
            <a href="reiniciarSesion.php?" class="btn-insert inline-flex items-center px-6 py-3 border border-transparent text-sm leading-4 font-bold rounded-full shadow-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                
                Cerrar sesion
            </a>
        </div>



        <div class="overflow-x-auto shadow-xl rounded-xl">
            <?php if (!empty($lista_productos)): ?>
                <table class="min-w-full table-neumorphic text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-gray-600 uppercase tracking-wider">
                            <th class="px-6 py-3 rounded-tl-xl">ID</th>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Descripción</th>
                            <th class="px-6 py-3">Precio</th>
                            <?php if ($rol == "admin"): ?>
                                <th class="px-6 py-3 rounded-tr-xl">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="product-list-body">
                        <?php foreach ($lista_productos as $prod): ?>
                            <tr class="border-b border-gray-100 hover:bg-blue-50/50 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 font-mono text-xs text-gray-500"><?php echo $prod['id_producto']; ?></td>
                                <td class="px-6 py-4 font-semibold text-gray-900"><?php echo $prod['nombre']; ?></td>
                                <td class="px-6 py-4 text-gray-500 truncate max-w-xs"><?php echo $prod['descripcion']; ?></td>
                                <td class="px-6 py-4 font-bold text-lg text-green-600"><?php echo number_format($prod['precio'], 2); ?> €</td>
                                <?php if ($rol == "admin"): ?>
                                    <td class="px-6 py-4 space-x-4 whitespace-nowrap">
                                        <a href="productos_borrar.php?id=<?= $prod['id_producto'] ?>" class="font-medium text-red-500 hover:text-red-700 transition duration-150 action-link">Eliminar</a>
                                        <a href="update.php?id=<?= $prod['id_producto'] ?>" class="font-medium text-blue-500 hover:text-blue-700 transition duration-150 action-link">Actualizar</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <?php else : ?> -->
                <div id="no-products-message" class="p-6 text-center bg-gray-50 rounded-lg hidden">
                    <h4 class="text-lg font-semibold text-gray-500">No existe ningún producto ahora mismo</h4>
                    <p class="text-sm text-gray-400 mt-1">Utiliza el botón 'Insertar uno Nuevo' para empezar.</p>
                </div>
                <!-- <?php endif; ?> -->
        </div>

        </div>
</body>

</html>