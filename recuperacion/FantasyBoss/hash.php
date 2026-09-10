<?php
/**
 * Script para generar hashes de contraseñas.
 * Uso: Accede a este archivo desde el navegador para obtener el hash.
 */

$password = '1234';
$hash = password_hash($password, PASSWORD_BCRYPT);

echo "<h3>Generador de Hash para FantasyBoss</h3>";
echo "<b>Password:</b> " . $password . "<br>";
echo "<b>Hash generado:</b> <code style='background: #eee; padding: 2px 5px;'>" . $hash . "</code><br><br>";

echo "<b>Comando SQL para actualizar el manager MAN-001:</b><br>";
echo "<pre style='background: #f4f4f4; padding: 10px; border: 1px solid #ddd;'>";
echo "UPDATE managers SET pin = '$hash' WHERE cod_manager = 'MAN-001';";
echo "</pre>";
