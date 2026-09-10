<?php

use Ezequiel\App\controllers\LoginController;
use Ezequiel\App\controllers\RefugioController;
use Ezequiel\Lib\Route;


/**
 * Definición de rutas de la aplicación
 */
Route::get("/", [RefugioController::class, 'index']);
Route::get("/login", [LoginController::class, 'index']);
Route::post("/login", [LoginController::class, 'verificarUsuario']);
Route::get("/logout", [LoginController::class, 'logout']);

Route::handleRoute();
