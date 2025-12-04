<?php
session_start();

// destruimos las variables de la siseion
session_unset();
session_destroy();

// redirigimos al login
header("Location: index.php");
exit();

?>