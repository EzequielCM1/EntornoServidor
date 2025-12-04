<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }
        /* Estilos personalizados para el efecto neomorfo / de tarjeta elevada */
        .login-card {
            box-shadow: 
                -10px -10px 30px #ffffff,
                10px 10px 30px rgba(174, 174, 192, 0.4);
            transition: all 0.3s ease;
        }
        .login-card:hover {
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
    </style>
</head>
<body class="p-4">

    <!-- Contenedor principal de la tarjeta de login, centrado y responsive -->
    <div class="login-card bg-white p-8 sm:p-10 rounded-3xl w-full max-w-sm mx-auto">
        
        <!-- Encabezado -->
        <header class="text-center mb-8">
            <svg class="mx-auto h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-1m3-4a3 3 0 00-3 3v1"></path>
            </svg>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-2">
                ¡Bienvenido de Nuevo!
            </h1>
            <p class="mt-2 text-sm text-gray-500">
                Inicia sesión en tu cuenta.
            </p>
        </header>

        <!-- Formulario de Login -->
        <form id="loginForm" class="space-y-6" method="post">
            
            <!-- Campo de Usuario/Email -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Usuario
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        placeholder="Tu nombre"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-inner transition duration-150 ease-in-out"
                    />
                    <!-- Icono para el campo de usuario -->
                    <svg class="absolute right-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1a8 8 0 01-16 0v-1m8 8v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-1m18-1v1a3 3 0 01-3 3h-2"></path>
                    </svg>
                </div>
                <?php if(!empty($errores['nombre'])): ?>
                <span style="color: red;"><?= $errores['nombre'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Campo de Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Contraseña
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-inner transition duration-150 ease-in-out"
                    />
                    <!-- Icono para el campo de contraseña -->
                    <svg class="absolute right-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2v5a2 2 0 01-2 2h-2m2-4v4m0 0h-4M5 9h11a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2z"></path>
                    </svg>
                </div>
                <?php if(!empty($errores['password'])): ?>
                <span style="color: red;"><?= $errores['password'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Botón de Enviar (Login) -->
            <div>
                <button 
                    type="submit" 
                    class="btn-submit w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Iniciar Sesión
                </button>
            </div>
            <div>
                <?php if(!empty($mensaje)) : ?>
                    <span style="color: red;"><?= $mensaje ?></span>
                <?php endif; ?>
            </div>
        </form>

    </div>
</body>
</html>