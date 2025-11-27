<?php
// Mismo encabezado, navegación y pie de página repetidos
// El formulario aquí no enviaría un mensaje flash, sino que se auto-procesaría o iría a otro archivo.


?>
 <?php if (!empty($mensaje)) : ?>
    <div class='notice'>
           <p class='notice'><?= htmlspecialchars($mensaje); ?></p>
    </div>
       <?php endif; ?>
    
<main class="contenedor-principal">
    <h2>Contáctanos</h2>
    <p>Envíanos tus dudas. (Este formulario no tiene la lógica de mensajes flash centralizada).</p>

    <!-- El formulario se enviaría a sí mismo o a un archivo procesador -->
    <form action="?p=contacto" method="POST" class="formulario-contacto">
        <label for="nombre">Tu nombre:</label><br>
        <input type="text" id="nombre" name="nombre" placeholder="Ej: María"><br><br>

        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe aquí..."></textarea><br><br>

        <button type="submit" name="enviar">Enviar Mensaje</button>
    </form>
</main>