# 📝 SIMULACRO DE EXAMEN DWES: Módulo de Entrenamiento

Este simulacro está diseñado para que practiques el flujo completo de una funcionalidad MVC con transacciones, siguiendo el estilo de la solución **Monroy Delivery**. Estás trabajando sobre una base de datos 100% aislada.

## 🚀 Escenario
El refugio ha decidido implementar un **Plan de Entrenamiento** para mejorar las posibilidades de adopción de los animales. Debes desarrollar un módulo que permita a los empleados asignar animales "Sanos" a diferentes tipos de entrenamiento.

---

## 🛠️ Requisitos Técnicos
1.  **Seguridad**: Todos los métodos de `EntrenamientoController` deben verificar que el usuario esté autenticado.
2.  **Mensajes Flash**: Usa tu `SessionManager::setMensajeFlash` (o similar) para informar del éxito o error.
3.  **Transacciones**: El proceso final de asignar un entrenamiento debe realizarse dentro de un `try/catch` usando `$db->beginTransaction()`, `$db->commit()` y `$db->rollback()`.
4.  **Flujo Multi-paso**:
    - **Paso 1**: Selección de animal (desde una lista de animales con `estado = 'Sano'`).
    - **Paso 2**: Configuración (elegir nivel: Básico, Medio, Avanzado).
    - **Paso 3**: Confirmación y persistencia en BD.

---

## 📋 Tareas Paso a Paso

### 1. Preparar Entorno
1. Ejecuta el archivo `entrenamiento.sql` en tu MySQL (ej: desde phpMyAdmin). Esto creará la BD `simulacro_refugio`.
2. Las credenciales en `lib/db_credentials.php` ya están apuntando a esta nueva BD aislada.

### 2. Controlador (`app/Controllers/EntrenamientoController.php`)
Ve al archivo y rellena los **TODO**. Tienes que:
- Usar tu `SessionManager` para proteger la ruta.
- Redirigir correctamente usando `BASE_URL`.
- Guardar el `id_animal` en sesión temporalmente al seleccionar.

### 3. Modelo (`app/Models/EntrenamientoModel.php`)
Ve al archivo y rellena los **TODO**:
- Completa la consulta SELECT para animales sanos.
- Realiza el `UPDATE` en animales y el `INSERT` en la tabla nueva dentro de la función `registrarEntrenamiento`.

### 4. Vistas (`app/Views/entrenamiento/`)
Abre `index_view.php` y `config_view.php`:
- Dibuja la tabla recorriendo `$data['animales']`.
- Haz los formularios para enviar los IDs por método `POST`.

---

## ⚖️ Criterios de Autoevaluación
- ¿Puedes entrar a `/entrenamiento` sin estar logueado? (Debería redirigirte al login).
- Si seleccionas un animal y luego desistes, ¿se queda el ID colgado en sesión o lo limpias al final?
- Si falla la inserción, ¿se cambia el estado del animal? (No debería, el rollback debe evitarlo).

> [!TIP]
> Tienes el login configurado con usuario **admin** y contraseña **1234**. Empieza introduciendo esa credencial en la ruta `/login`.
