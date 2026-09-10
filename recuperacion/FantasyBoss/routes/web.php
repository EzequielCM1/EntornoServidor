<?php

/*
 * ══════════════════════════════════════════════════════════════
 *  FantasyBoss — web.php
 * ══════════════════════════════════════════════════════════════
 *
 * NAMESPACES a importar:
 *   use Ezequiel\App\controllers\FantasyLoginController;
 *   use Ezequiel\App\controllers\FantasyController;
 *   use Ezequiel\Lib\Route;
 *
 * RUTAS A DEFINIR:
 * ┌──────────────────────────────┬────────┬──────────────────────────────────────────────┐
 * │ URI                          │ Método │ Controlador::método                          │
 * ├──────────────────────────────┼────────┼──────────────────────────────────────────────┤
 * │ /                            │ GET    │ FantasyController::index                     │
 * │ /login                       │ GET    │ FantasyLoginController::mostrarFormularioLogin│
 * │ /login                       │ POST   │ FantasyLoginController::autenticarManager    │
 * │ /logout                      │ GET    │ FantasyLoginController::cerrarSesion         │
 * │ /jornadas                    │ GET    │ FantasyController::jornadas                  │
 * │ /mi-plantilla                │ GET    │ FantasyController::miPlantilla               │
 * │ /confirmar-fichaje           │ POST   │ FantasyController::confirmarFichaje          │
 * │ /fichar/{id}                 │ POST   │ FantasyController::mostrarFichar             │
 * │ /liberar/{id}                │ POST   │ FantasyController::liberarJugador            │
 * └──────────────────────────────┴────────┴──────────────────────────────────────────────┘
 *
 * REGLA: /confirmar-fichaje (fija) ANTES de /fichar/{id} y /liberar/{id} (con parámetro)
 *
 * Al final: Route::handleRoute();
 */

// TODO: escribe aquí los use y las rutas


use Ezequiel\App\controllers\FantasyLoginController;
use Ezequiel\App\controllers\FantasyController;
use Ezequiel\Lib\Route;

Route::get("/", [FantasyController::class,'index']);
Route::get("/login", [FantasyLoginController::class,'mostrarFormularioLogin']);
Route::post('/login', [FantasyLoginController::class,'autenticarManager']);
Route::get('/logout', [FantasyLoginController::class,'cerrarSesion']);
Route::get('/jornadas', [FantasyController::class,'jornadas']);
Route::get('/mi-plantilla', [FantasyController::class,'miPlantilla']);
Route::post('/confirmar-fichaje', [FantasyController::class,'confirmarFichaje']);
Route::post('/fichar/{id}', [FantasyController::class,'mostrarFichar']);
Route::post('/liberar/{id}', [FantasyController::class,'liberarJugador']);

Route::get("/proyectos/php/recuperacion/FantasyBoss/login", [FantasyLoginController::class, 'mostrarFormularioLogin']);

Route::handleRoute();