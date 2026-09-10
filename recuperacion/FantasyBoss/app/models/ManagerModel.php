<?php

namespace Ezequiel\App\models;

use Ezequiel\Lib\Database;

class ManagerModel {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // autenticarManager($cod_manager, $pin)
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // SQL: SELECT cod_manager, nombre, apellidos, pin, liga, puntos_totales, activo
    //      FROM managers WHERE cod_manager = ?
    //
    // Si empty($resultado)            → return false  (no existe)
    // $manager = $resultado[0]
    // Si (int)$manager['activo'] != 1 → return false  (baneado)
    // Si !password_verify($pin, $manager['pin']) → return false  (pin incorrecto)
    //
    // return [
    //     'cod_manager'    => $manager['cod_manager'],
    //     'nombre'         => $manager['nombre'],
    //     'apellidos'      => $manager['apellidos'],
    //     'liga'           => $manager['liga'],
    //     'puntos_totales' => $manager['puntos_totales']
    // ];
    // ─────────────────────────────────────────────────────────────────────────
    public function autenticarManager($cod_manager, $pin) {
        $sql = "SELECT * FROM managers WHERE cod_manager = ?";
        $resultado = $this->db->executeQuery($sql, [$cod_manager]);

        if (empty($resultado)) {
            return false;
        }

        $manager = $resultado[0];

        if ((int)$manager['activo'] !== 1) {
            return false;
        }

        if (password_verify($pin, $manager['pin'])) {
            return [
                'cod_manager'    => $manager['cod_manager'],
                'nombre'         => $manager['nombre'],
                'apellidos'      => $manager['apellidos'],
                'liga'           => $manager['liga'],
                'puntos_totales' => $manager['puntos_totales']
            ];
        }

        return false;
    }
}
