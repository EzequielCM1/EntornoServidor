<?php

//use Pepelluyot\App\controllers\ProductosController;
use Pepelluyot\Lib\Route;
use Pepelluyot\App\controllers\LoginController;
use Pepelluyot\App\controllers\LogisticaController;

// Ruta de login
Route::get('/login', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'authenticate']);

// Ruta de logout
Route::get('/logout', [LoginController::class, 'logout']);

// // Ruta principal - Listado de vehículos
Route::get('/', [LogisticaController::class, 'index']);
Route::get('/vehiculos', [LogisticaController::class, 'index']);

// // Ruta de asignación de vehículo
Route::post('/asignar-vehiculo', [LogisticaController::class, 'asignarVehiculo']);

// // Ruta de gestión de carga
Route::get('/carga', [LogisticaController::class, 'mostrarCarga']);
Route::post('/calcular-carga', [LogisticaController::class, 'calcularCargaOptima']);

// // Ruta de confirmación de envío
Route::post('/confirmar-envio', [LogisticaController::class, 'confirmarEnvio']);

//llamamos al manejador de rutas
Route::handleRoute();
