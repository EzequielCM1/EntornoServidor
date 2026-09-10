<?php

/**
 * EJERCICIOS DE LÓGICA PHP - MODO PRÁCTICA
 * 
 * Instrucciones: Escribe la línea de código solicitada debajo de cada comentario.
 */

use Ezequiel\Lib\SessionManager;

// --- RETO 1: REDONDEO PRECISO ---
// Situación: Tienes la variable $peso_total = 150.4567. 
// Redondéala a 2 decimales y guárdala en la misma variable.
$peso_total = 150.4567;
// CORRECCIÓN: Usar '=' para asignar y la misma variable $peso_total.
$peso_total = round($peso_total, 2);


// --- RETO 2: LIMPIEZA DE DATOS ---
// Situación: Recibes $_POST['id_vehiculo']. 
// Guárdalo en $id eliminando espacios en blanco a los lados.
// CORRECCIÓN: trim() es suficiente para limpiar. Usamos ?? para evitar errores si no existe el POST.
$id = trim($_POST['id_vehiculo'] ?? '');


// --- RETO 3: EL VALOR POR DEFECTO ---
// Situación: Obtén 'mensaje_flash' de la sesión usando SessionManager::get('mensaje_flash').
// Si no existe, la variable $mensaje debe ser null. (Usa ??)
$mensaje = SessionManager::get('mensaje_flash') ?? null;

// Vista (Ejemplo):
?>
<?php if ($mensaje) : ?>
    <!-- CORRECCIÓN: Te faltaba el '=' o 'echo' en la clase del párrafo -->
    <p class="success <?= $mensaje['tipo'] ?>"><?= $mensaje['mensaje'] ?></p>
<?php endif; ?>

<?php
// --- RETO 4: VERIFICACIÓN DE NÚMEROS ---
// Situación: Escribe un IF que compruebe si $id está VACÍO o si NO es un número.
$id = "abc"; 
// Tu código (Bien hecho):
if (empty($id)) {
    $mensaje = "Está vacío";
} elseif (!is_numeric($id)) {
    $mensaje = "No es un número";
}


// --- RETO 5: FORMATEO DE TEXTO ---
// Situación: Pasa la primera letra de $nombre = "ezequiel" a mayúsculas.
$nombre = "ezequiel";
// Tu código aquí:
$nombre = ucfirst($nombre); //esto convierte la primera letra en mayusculas 


// nota 
/* Asegurar formato correcto (Minúsculas + Capitalizado)
Para evitar que palabras en mayúsculas sostenidas se mantengan así (ej. "HOLA" -> "HOLA"), se combina con strtolower.
php
$texto = "hOLA mUNDO";
echo ucfirst(strtolower($texto)); // Salida: "Hola mundo"
echo ucwords(strtolower($texto)); // Salida: "Hola Mundo"
*/


// --- RETO 6: REDIRECCIÓN ---
// Situación: Redirige al usuario a la página de login usando BASE_URL . 'login'.
// define('BASE_URL', '/mi_proyecto/'); 
$usuario = ""; 
// CORRECCIÓN: concatenar BASE_URL con 'login' directamente.
if (empty($usuario)) {
    header("Location: " . BASE_URL . "login");
    exit();
}


// --- RETO 7: ARRAYS Y CONTEOS ---
// Situación: Si el array $paquetes no tiene ningún elemento, muestra el mensaje "No hay paquetes".
$paquetes = []; 
// Tu código (Correcto):
if (count($paquetes) == 0) {
    echo "No hay paquetes";
}


// --- RETO 8: CONCATENACIÓN ---
// Situación: Junta $marca = "Iveco" y $modelo = "Daily" con un espacio en medio en la variable $nombre_completo.
$marca = "Iveco";
$modelo = "Daily";
// CORRECCIÓN: Tenías un error con '$Daily' (es $modelo). Lo más simple es el punto '.'.
$nombre_completo = $marca . " " . $modelo;


// --- RETO 9: PORCENTAJES ---
// Situación: Un animal tiene $puntos = 80. Calcula el 20% y guárdalo en $descuento.
$puntos = 80;
// Tu código (Correcto):
$descuento = $puntos * 0.20;


// --- RETO 10: EXISTENCIA DE ARCHIVOS ---
// Situación: Comprueba si el archivo "public/img/gato1.jpg" existe antes de intentar usarlo.
$ruta = "public/img/gato1.jpg";
// CORRECCIÓN: El echo no lleva el signo '='.
if (!file_exists($ruta)) {
    echo "No existe el archivo";
}

// ==========================================
// NUEVOS RETOS (11-15) - ¡Sube el nivel!
// ==========================================

// --- RETO 11: MANEJO DE FECHAS ---
// Situación: Tienes la fecha actual en 'Y-m-d' en la variable $hoy. 
// Quieres sumarle 7 días y guardarlo en $proxima_revision.
$hoy = date('Y-m-d');
// Tu código aquí:

// Opción 1: Clásica con strtotime
$proxima_revision = date('Y-m-d', strtotime($hoy . ' + 7 days'));

// Opción 2: Moderna orientada a objetos (Recomendada)
$fecha = new DateTime($hoy);
$fecha->modify('+7 days');
$proxima_revision = $fecha->format('Y-m-d');


// --- RETO 12: BUCLES (FOREACH) ---
// Situación: Tienes un array asociativo $empleado = ['nombre' => 'Pepe', 'rol' => 'Admin'].
// Recórrelo para imprimir: "nombre: Pepe", "rol: Admin".
$empleado = ['nombre' => 'Pepe', 'rol' => 'Admin'];
// Tu código aquí:
foreach($empleado as $emp){
    echo $emp["nombre"];
    echo $emp["rol"];
}
// o
$empleado = ['nombre' => 'Pepe', 'rol' => 'Admin'];

foreach ($empleado as $clave => $valor) {
    echo "$clave: $valor <br>"; 
}

// --- RETO 13: BÚSQUEDA EN STRINGS ---
// Situación: Tienes un $email. Usa una función de PHP para comprobar si CONTIENE el carácter '@'.
$email = "test@correo.com";
// Tu código aquí:
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    return;
}else{
    $posicion = strpos($email, "@");
}

if($posicion == true){
    echo "si esta dentro el @ , esta en la posicion $posicion ";
}
// o tambien 
$email = "test@correo.com";

// Forma moderna (PHP 8+)
if (str_contains($email, '@')) {
    echo "Sí contiene el @";
}

// Forma clásica (PHP 7 o inferior)
if (strpos($email, '@') !== false) {
    echo "Sí contiene el @";
}

// --- RETO 14: SESIONES COMPLEJAS ---
// Situación: Tienes los datos de un animal en un array $animal = ['id' => 1, 'nombre' => 'Luna'].
// Guárdalo completo en la sesión con la clave 'animal_seleccionado'.
$animal = ['id' => 1, 'nombre' => 'Luna'];
// Tu código aquí:
session_start();
$_SESSION["animal_seleccionado"] = $animal;


// --- RETO 15: EL OPERADOR TERNARIO ---
// Situación: Tienes una variable $puntos = 40. 
// Si $puntos es mayor o igual a 50, $resultado debe ser "Apto". 
// Si es menor, $resultado debe ser "No Apto". Hazlo en UNA SOLA LÍNEA (operador ? :).
$puntos = 40;
// Tu código aquí:
if($puntos >= 50){
    $resultado = "apto";
}else{
    $resultado = "No apto";
}


// ==========================================
// SOLUCIONES A LOS RETOS (16-20)
// ==========================================

// --- RETO 16: MANEJO DE JSON ---
// Situación: Tienes un array de datos y necesitas enviarlo a una API o a JavaScript.
// Convierte el array $respuesta a un string de texto en formato JSON y guárdalo en $json.
$respuesta = ['status' => 'success', 'code' => 200, 'message' => 'Todo OK'];
$json = json_encode($respuesta);


// --- RETO 17: SEGURIDAD (CONTRASEÑAS) ---
// Situación: Encríptala usando la función nativa recomendada de PHP y guárdala en $hash.
$password_plana = "123456";
$hash = password_hash($password_plana, PASSWORD_DEFAULT);


// --- RETO 18: FILTRADO RÁPIDO DE ARRAYS ---
// Situación: Quédate solo con las edades mayores o iguales a 18.
$edades = [15, 22, 18, 12, 30];
$mayores = array_filter($edades, fn($edad) => $edad >= 18);


// --- RETO 19: MANEJO DE ERRORES (TRY/CATCH) ---
// Situación: Llama a la función 'procesar_pago()' y atrapa cualquier excepción en $error.
$error = null;
try {
    // procesar_pago(); 
} catch (Exception $e) {
    $error = $e->getMessage();
}


// --- RETO 20: MATCH (PHP 8) ---
// Situación: Convierte $estado_pedido (1, 2, 3) en texto ("Pendiente", "Enviado", "Entregado").
$estado_pedido = 2;
$texto = match($estado_pedido) {
    1 => "Pendiente",
    2 => "Enviado",
    3 => "Entregado",
    default => "Desconocido",
};


// ==========================================
// RETOS AVANZADOS (21-30) - Basados en el proyecto
// ==========================================

// --- RETO 21: TRANSACCIONES (MySQLi) ---
// Situación: Usa la clase Database (Ezequiel\Lib\Database) para una transacción.
$db = new \Ezequiel\Lib\Database();
try {
    $db->beginTransaction();
    $db->executeUpdate("UPDATE animales SET estado = 'Revision' WHERE id = ?", [1]);
    $db->commit();
} catch (Exception $e) {
    $db->rollback();
}


// --- RETO 22: EXTRACCIÓN DE COLUMNAS ---
// Situación: Extrae solo los nombres de los animales del array $animales.
$animales = [['nombre' => 'Luna'], ['nombre' => 'Thor']];
$nombres = array_column($animales, 'nombre');


// --- RETO 23: SEGURIDAD (XSS) ---
// Situación: Escapa $nombre_usuario para mostrarlo en HTML.
$nombre_usuario = "<b>Juan</b>";
?>
<p>Hola <?= htmlspecialchars($nombre_usuario, ENT_QUOTES, 'UTF-8') ?></p>

<?php
// --- RETO 24: OPERACIONES DE ESCRITURA ---
// Situación: Borra el animal con id 5 usando executeUpdate.
$db->executeUpdate("DELETE FROM animales WHERE id = ?", [5]);


// --- RETO 25: GESTIÓN DE SESIÓN (LOGOUT) ---
// Situación: Limpia y destruye la sesión.
$_SESSION = [];
// session_destroy(); (Comentado para evitar errores si no hay sesión activa en el test)


// --- RETO 26: TRANSFORMACIÓN (ARRAY_MAP) ---
// Situación: Convierte todos los nombres de $animales a MAYÚSCULAS.
$animales_upper = array_map(fn($a) => strtoupper($a['nombre']), $animales);


// --- RETO 27: VALIDACIÓN DE ARCHIVOS ---
// Situación: Comprueba si la extensión de "foto.png" es permitida (jpg, png).
$archivo = "foto.png";
$ext = pathinfo($archivo, PATHINFO_EXTENSION);
$permitidos = ['jpg', 'png'];
if (in_array($ext, $permitidos)) {
    echo "Archivo válido";
}


// --- RETO 28: LISTAS Y STRINGS (EXPLODE) ---
// Situación: Convierte el string "perro,gato,loro" en un array.
$lista = "perro,gato,loro";
$animales_array = explode(",", $lista);


// --- RETO 29: EXISTENCIA DE CLAVES ---
// Situación: Comprueba si existe la clave 'tipo' en el array $mensaje.
$mensaje = ['tipo' => 'error', 'texto' => 'Fallo'];
if (array_key_exists('tipo', $mensaje)) {
    echo $mensaje['tipo'];
}


// --- RETO 31: FILTRADO POR CONDICIÓN ---
// Situación: De un array de $productos, quédate solo con los que tengan stock > 0.
$productos = [
    ['nombre' => 'Teclado', 'stock' => 10],
    ['nombre' => 'Ratón', 'stock' => 0],
    ['nombre' => 'Monitor', 'stock' => 5]
];
// Tu código aquí:
$disponibles = array_filter($productos, fn($p) => $p['stock'] > 0);


// --- RETO 32: BÚSQUEDA DE UN SÓLO ELEMENTO ---
// Situación: Encuentra el primer animal en $animales que tenga el nombre 'Thor'.
$animales = [
    ['id' => 1, 'nombre' => 'Luna'],
    ['id' => 2, 'nombre' => 'Thor'],
    ['id' => 3, 'nombre' => 'Thor'] // Duplicate name
];
// Tu código aquí:
$indice = array_search('Thor', array_column($animales, 'nombre'));
$thor = ($indice !== false) ? $animales[$indice] : null;


// --- RETO 33: RENDERIZADO CONDICIONAL ---
// Situación: Si $usuario['rol'] es 'admin', muestra un enlace a "Panel Control".
// Si no, muestra "Vista Usuario".
$usuario = ['nombre' => 'Zequi', 'rol' => 'admin'];
?>
<?php if ($usuario['rol'] === 'admin') : ?>
    <a href="/admin">Panel Control</a>
<?php else : ?>
    <span>Vista Usuario</span>
<?php endif; ?>

<?php
// --- RETO 34: CONTEO ESPECÍFICO ---
// Situación: Cuenta cuántos 'perros' hay en el array de $especies.
$especies = ['perro', 'gato', 'perro', 'loro', 'perro'];
// Tu código aquí:
$conteos = array_count_values($especies);
$num_perros = $conteos['perro'] ?? 0;


// --- RETO 35: FORMATEO DE MONEDA ---
// Situación: Tienes $precio = 1250.5. Muéstralo como "1.250,50 €".
$precio = 1250.5;
// Tu código aquí:
echo number_format($precio, 2, ',', '.') . " €";


// --- RETO 36: COMPARACIÓN DE FECHAS ---
// Situación: Comprueba si la fecha $vencimiento es anterior a la fecha $hoy.
$vencimiento = "2024-01-01";
$hoy = date("Y-m-d");
// Tu código aquí:
if (strtotime($vencimiento) < strtotime($hoy)) {
    echo "Ha caducado";
}


// --- RETO 37: MANEJO DE NULL (COALESCE) ---
// Situación: Si $_GET['pagina'] no existe, $pagina debe ser 1.
// Tu código aquí:
$pagina = $_GET['pagina'] ?? 1;


// --- RETO 38: UNIÓN DE ARRAYS ASOCIATIVOS ---
// Situación: Tienes $datos_base y $datos_nuevos. Júntalos (los nuevos sobrescriben).
$datos_base = ['id' => 1, 'nombre' => 'Antiguo'];
$datos_nuevos = ['nombre' => 'Nuevo', 'edad' => 5];
// Tu código aquí:
$resultado = array_merge($datos_base, $datos_nuevos);


// --- RETO 39: COMPROBACIÓN DE CAMPOS VACÍOS EN FORMULARIO ---
// Situación: Escribe un IF que sea verdadero si 'nombre' O 'email' están vacíos en $_POST.
// Tu código aquí:
if (empty($_POST['nombre']) || empty($_POST['email'])) {
    echo "Faltan campos obligatorios";
}


// --- RETO 40: SQL (QUERY DE ACTUALIZACIÓN) ---
// Situación: Escribe la sentencia SQL para cambiar el nombre a 'Rex' donde el id sea 3.
// solo escribe el string de la consulta.
$sql = "UPDATE animales SET nombre = 'Rex' WHERE id = 3";

?>
