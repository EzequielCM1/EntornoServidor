<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <!-- Carga de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuración para usar la fuente Inter y personalizar colores -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            /* Fondo con degradado suave */
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e3f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem; /* Asegurar espacio en móvil */
        }
        /* Estilos personalizados para el efecto de tarjeta elevada (Neumorfismo) */
        .update-card {
            box-shadow: 
                -10px -10px 30px #ffffff,
                10px 10px 30px rgba(174, 174, 192, 0.4);
            transition: all 0.3s ease;
        }
        .update-card:hover {
            box-shadow: 
                -15px -15px 40px #ffffff,
                15px 15px 40px rgba(174, 174, 192, 0.6);
        }
        /* Estilo para el botón con efecto de presión */
        .btn-submit {
            transition: all 0.2s ease;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1), -4px -4px 10px #ffffff;
        }
        .btn-submit:active {
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1), inset -2px -2px 5px #ffffff;
            transform: translateY(1px);
        }
        /* Estilo para el campo ID deshabilitado */
        .input-disabled {
            background-color: #eef1f5;
            color: #9ca3af;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="p-4">

    <!-- Contenedor principal de la tarjeta de actualización, centrado y responsive -->
    <div class="update-card bg-white p-8 sm:p-10 rounded-3xl w-full max-w-lg mx-auto">
        
        <!-- Encabezado -->
        <header class="text-center mb-8">
            <svg class="mx-auto h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 15m14.356-2H20v-5m-7-2h2m-2 4h2M9 7h.01M9 11h.01M9 15h.01M16 17H5a2 2 0 01-2-2v-4a2 2 0 012-2h11a2 2 0 012 2v4a2 2 0 01-2 2z"></path>
            </svg>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-2">
                Actualizar Datos del Producto
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Modifica los campos necesarios y guarda los cambios.
            </p>
        </header>

        <!-- Formulario de Actualización -->
        <form class="space-y-6" method="post">
            
            <!-- Campo ID (Solo Lectura) -->
            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                    ID del Producto
                </label>
                <input 
                    type="text" 
                    id="product_id" 
                    name="product_id" 
                    value="<?= $fila['id_producto']?>"
                    readonly 
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-inner input-disabled"
                />
            </div>

            <!-- Campo Nombre -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre del Producto
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?= $fila['nombre']?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-inner transition duration-150 ease-in-out"
                />
                <?php if(!empty($errores['nombre'])): ?>
                    <span style="color: red;"><?= $errores['nombre'] ?></span>
                    <?php endif; ?>
            </div>

            <!-- Campo Descripción -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-inner transition duration-150 ease-in-out resize-none"
                ><?= $fila['descripcion']?></textarea>
            </div>

            <!-- Campo Precio -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                    Precio (€)
                </label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    value="<?= $fila['precio']?>"
                    step="0.01"
                    min="0"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-inner transition duration-150 ease-in-out"
                />
            </div>

            <!-- Botón de Enviar (Actualizar) -->
            <div>
                <button 
                    type="submit" 
                    class="btn-submit w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</body>
</html>