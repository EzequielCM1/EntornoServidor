<?php
/**
 * 📚 CHULETA PHP - CONCEPTOS PARA EL EXAMEN DWES
 */

// ---------------------------------------------------------
// 1. MATEMÁTICAS Y REDONDEO
// ---------------------------------------------------------
$valor = 10.6789;

$suma = $valor + 5;
$redondeo = round($valor, 2);       // 10.68 (número de decimales)
$al_alza = ceil($valor);          // 11 (entero superior)
$a_la_baja = floor($valor);       // 10 (entero inferior)
$formato = number_format($valor, 2, ',', '.'); // "10,68" (texto para mostrar)

// --- Calcular Media y Suma de un Array ---
$precios = [10, 20, 30, 40];
$total_suma = array_sum($precios);   // 100
$cantidad = count($precios);         // 4
$media = ($cantidad > 0) ? ($total_suma / $cantidad) : 0; // 25 (Evita division por cero)
$media_formateada = round($media, 2);

// ---------------------------------------------------------
// 2. FECHAS Y TIEMPO
// ---------------------------------------------------------
$hoy = date("Y-m-d H:i:s");        // "2026-04-06 19:30:00"
$ayer = date("Y-m-d", strtotime("-1 day")); // "2026-04-05"

// Comparar fechas (convertir a timestamp)
$fecha1 = "2026-01-01";
$fecha2 = "2026-02-01";
if (strtotime($fecha1) < strtotime($fecha2)) {
    // fecha1 es anterior a fecha2
}

// ---------------------------------------------------------
// 3. VALIDACIONES ESENCIALES
// ---------------------------------------------------------
$dato = $_POST['usuario'] ?? '';

if (empty($dato)) { /* Está vacio, es null, o es "" o es 0 */ }
if (isset($dato)) { /* La variable existe y no es null */ }

// Validar Email
if (!filter_var("correo@ejemplo.com", FILTER_VALIDATE_EMAIL)) {
    echo "Email no válido";
}

// Validar Número
if (is_numeric("123.45")) { /* Es un número o un string numérico */ }

// Limpiar HTML (Seguridad XSS)
$limpio = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');

// ---------------------------------------------------------
// 4. STRINGS Y ARRAYS
// ---------------------------------------------------------
$frase = "  Hola Mundo  ";
$sin_espacios = trim($frase);      // Quita espacios bordes
$mayusculas = strtoupper($frase);  // TODO A MAYUS
$minusculas = strtolower($frase);  // todo a minus

// Arrays
$letras = ["a", "b", "c"];
$str = implode(", ", $letras);      // "a, b, c" (Juntar)
$array = explode(", ", $str);       // [a, b, c] (Separar)
$unido = array_merge($letras, ["d", "e"]); // [a, b, c, d, e]
$total = count($letras);            // 3

// ---------------------------------------------------------
// 5. SESIONES Y REDIRECCIONES
// ---------------------------------------------------------
// session_start(); (Ya lo hace el SessionManager)
// header("Location: ruta"); 
// exit(); (Siempre después de un header Location)

// ---------------------------------------------------------
// 6. PASSWORD (CONTRASEÑAS)
// ---------------------------------------------------------
$hash = password_hash("1234", PASSWORD_DEFAULT); // Encriptar
if (password_verify("1234", $hash)) { /* Correcto */ }

// ---------------------------------------------------------
// 7. OPERADORES LÓGICOS (AND, OR)
// ---------------------------------------------------------
// if ($a && $b) { /* Ambos */ }
// if ($a || $b) { /* Uno de los dos */ }
// if (!$a) { /* Si NO es $a */ }

// ---------------------------------------------------------
// 8. CONSULTAS SQL (Sintaxis básica)
// ---------------------------------------------------------
/*
SELECT:  SELECT * FROM tabla WHERE condicion ORDER BY columna DESC
INSERT:  INSERT INTO tabla (col1, col2) VALUES (?, ?)
UPDATE:  UPDATE tabla SET col1 = ?, col2 = ? WHERE id = ?
DELETE:  DELETE FROM tabla WHERE id = ?
JOIN:    SELECT t1.nombre, t2.detalle 
         FROM tabla1 t1 
         INNER JOIN tabla2 t2 ON t1.id = t2.t1_id
*/

// ---------------------------------------------------------
// 9. TRANSACCIONES (Flujo seguro)
// ---------------------------------------------------------
/*
1. $db->beginTransaction(); // Congela la base de datos
2. try {
      $db->executeUpdate(...); 
      $db->executeUpdate(...);
      $db->commit();        // Guarda todo si todo fue bien
   } catch (Exception $e) {
      $db->rollback();      // Deshace todo si algo falló
   }
*/

// ---------------------------------------------------------
// 10. JSON Y APIs
// ---------------------------------------------------------
$lista = ["rojo", "azul"];
$json = json_encode($lista);        // De Array a Texto (JSON)
$array = json_decode($json, true);  // De Texto (JSON) a Array (el 'true' lo hace array)

// ---------------------------------------------------------
// 11. ARRAYS AVANZADOS (Hacer magia)
// ---------------------------------------------------------
$nums = [1, 2, 3, 4];
// array_map: Transforma cada elemento
$dobles = array_map(fn($n) => $n * 2, $nums); // [2, 4, 6, 8]

// array_filter: Filtra elementos
$pares = array_filter($nums, fn($n) => $n % 2 == 0); // [2, 4]

// array_column: Saca una columna de un array de arrays
$users = [['id' => 1, 'n' => 'A'], ['id' => 2, 'n' => 'B']];
$ids = array_column($users, 'id'); // [1, 2]

// ---------------------------------------------------------
// 12. CONSTANTES Y ARCHIVOS
// ---------------------------------------------------------
define('BASE_URL', '/proyecto/'); // Se usa para rutas de enlaces/redirecciones
// __DIR__ : Ruta absoluta de la carpeta donde está este archivo.

// $_FILES['nombre_input']:
// ['name']: nombre original
// ['tmp_name']: donde está guardado temporalmente
// ['error']: 0 si todo bien
// ['size']: tamaño en bytes

// ---------------------------------------------------------
// 13. RESUMEN DE FLUJO MVC
// ---------------------------------------------------------
/*
1. ROUTE: Recibe la URL y dice qué CONTROLADOR llamar.
2. CONTROLADOR: 
   - Pide datos al MODELO.
   - Procesa lógica (if/else, sesiones).
   - Carga la VISTA pasándole los datos.
3. MODELO: Habla con la DATABASE (SQL).
4. VISTA: HTML + datos del controlador.
*/