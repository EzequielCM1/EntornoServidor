<?php

use Ezequiel\App\controllers\LoginController;
use Ezequiel\App\controllers\LogisticaController;
use Ezequiel\Lib\Route;

//registramos todas las rutas posibles


//Route::post("/", [HomeController::class,'index']);

Route::get("/", [LogisticaController::class,'index']);
Route::get("/login", [LoginController::class,'index']);
Route::post("/login", [LoginController::class,'comprobarUsuario']);
Route::get('/logout', [LoginController::class, 'logout']);


Route::get('/carga', [LogisticaController::class, 'mostrarCarga']);
Route::post('/asignar-vehiculo', [LogisticaController::class, 'asignarVehiculo']);
Route::post('/calcular-carga', [LogisticaController::class, 'calcularCargaOptima']);
Route::post('/confirmar-envio', [LogisticaController::class, 'confirmarEnvio']);

Route::handleRoute();
