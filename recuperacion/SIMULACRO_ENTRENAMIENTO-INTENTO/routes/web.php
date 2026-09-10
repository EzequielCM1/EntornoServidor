<?php

use Ezequiel\App\controllers\LoginController;
use Ezequiel\App\controllers\RefugioController;
use Ezequiel\App\controllers\EntrenamientoController; // <-- Añadido para el simulacro
use Ezequiel\Lib\Route;


/**
 * Definición de rutas de la aplicación
 */
Route::get("/", [RefugioController::class, 'index']);
Route::get("/login", [LoginController::class, 'index']);
Route::post("/login", [LoginController::class, 'verificarUsuario']);
Route::get("/logout", [LoginController::class, 'logout']);

// ==========================================
// RUTAS DEL SIMULACRO DE ENTRENAMIENTO
// ==========================================
// TODO 1: Configura las rutas necesarias según el SIMULACRO_EXAMEN.md
// Piensa: ¿Qué ruta carga la vista de animales sanos? ¿Cuál procesa la selección?
Route::get("/entrenamiento", [EntrenamientoController::class, 'index']);
Route::post("/entrenamiento/seleccionar", [EntrenamientoController::class, 'seleccionar']);
Route::get("/entrenamiento/configurar", [EntrenamientoController::class, 'mostrarConfiguracion']);
Route::post("/entrenamiento/confirmar", [EntrenamientoController::class, 'confirmar']);
Route::post("/ficha", [RefugioController::class, "ficha"]);
Route::post("/entrenar", [RefugioController::class, "entrenar"]);
Route::get("/nuevoanimal" ,[RefugioController::class, "nuevoAnimal"]);
Route::post("/nuevoanimal" ,[RefugioController::class, "nuevoAnimalRegistrar"]);
Route::handleRoute();
