<?php
/**
 * Ejemplo de validaciones de formulario mediante POST
 */

// Inicialización de variables para evitar errores "undefined"
$nombre = $email = $edad = "";
$errores = [];
$exito = false;

// Comprobar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Recuperación y limpieza básica (trim)
    $nombre = trim($_POST['nombre'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $edad   = trim($_POST['edad'] ?? '');
    $password = $_POST['password'] ?? ''; // No solemos hacer trim a passwords

    // 2. Validaciones específicas
    
    // Validación Nombre: Requerido y solo letras/espacios
    if (empty($nombre)) {
        $errores['nombre'] = "El nombre es obligatorio.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]*$/", $nombre)) {
        $errores['nombre'] = "Solo se permiten letras y espacios.";
    }

    // Validación Email: Requerido y formato válido
    if (empty($email)) {
        $errores['email'] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El formato del correo no es válido.";
    }

    // Validación Edad: Requerido, número entero y rango (18-99)
    if (empty($edad)) {
        $errores['edad'] = "La edad es obligatoria.";
    } else {
        $edad_validada = filter_var($edad, FILTER_VALIDATE_INT, [
            "options" => ["min_range" => 18, "max_range" => 99]
        ]);
        if ($edad_validada === false) {
            $errores['edad'] = "Debes ser mayor de 18 años (máx 99).";
        }
    }

    // Validación Contraseña: Mínimo 8 caracteres
    if (strlen($password) < 8) {
        $errores['password'] = "La contraseña debe tener al menos 8 caracteres.";
    }

    // 3. Resultado final
    if (empty($errores)) {
        $exito = true;
        // Aquí procesarías los datos (guardar en BD, enviar email, etc.)
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validaciones PHP Modernas</title>
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f8fafc;
            --error: #ef4444;
            --success: #10b981;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: var(--card-bg);
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            margin-top: 0;
            font-size: 1.8rem;
            text-align: center;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #94a3b8;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 0.5rem;
            color: white;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        input.invalid {
            border-color: var(--error);
        }

        .error-msg {
            color: var(--error);
            font-size: 0.8rem;
            margin-top: 0.4rem;
        }

        .success-banner {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 1rem;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        .info {
            text-align: center;
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Registro de Usuario</h1>

    <?php if ($exito): ?>
        <div class="success-banner">
            ¡Formulario enviado con éxito!
        </div>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
        <!-- Nombre -->
        <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" name="nombre" id="nombre" 
                   value="<?= htmlspecialchars($nombre); ?>"
                   class="<?= isset($errores['nombre']) ? 'invalid' : ''; ?>"
                   placeholder="Ej: Juan Pérez">
            <?php if (isset($errores['nombre'])): ?>
                <div class="error-msg"><?= $errores['nombre']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="text" name="email" id="email" 
                   value="<?= htmlspecialchars($email); ?>"
                   class="<?= isset($errores['email']) ? 'invalid' : ''; ?>"
                   placeholder="correo@ejemplo.com">
            <?php if (isset($errores['email'])): ?>
                <div class="error-msg"><?= $errores['email']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Edad -->
        <div class="form-group">
            <label for="edad">Edad</label>
            <input type="number" name="edad" id="edad" 
                   value="<?= htmlspecialchars($edad); ?>"
                   class="<?= isset($errores['edad']) ? 'invalid' : ''; ?>"
                   placeholder="18">
            <?php if (isset($errores['edad'])): ?>
                <div class="error-msg"><?= $errores['edad']; ?></div>
            <?php endif; ?>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Contraseña (min. 8 carac.)</label>
            <input type="password" name="password" id="password" 
                   class="<?= isset($errores['password']) ? 'invalid' : ''; ?>"
                   placeholder="********">
            <?php if (isset($errores['password'])): ?>
                <div class="error-msg"><?= $errores['password']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Validar y Enviar</button>
    </form>

    <div class="info">
        Los datos se procesan mediante <strong>$_POST</strong> de forma segura.
    </div>
</div>

</body>
</html>