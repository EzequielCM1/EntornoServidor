<?php

namespace Ezequiel\App\models;

use Ezequiel\Lib\Database;

class FantasyModel {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // obtenerJugadores()
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // SELECT * FROM jugadores_reales ORDER BY puntos_media DESC
    // Si empty → return false
    // Si no   → return $resultado
    // ─────────────────────────────────────────────────────────────────────────
    public function obtenerJugadores($posicion = null) {
        $params = [];
        $sql = "SELECT * FROM jugadores_reales WHERE estado = 'Disponible'";
        
        if ($posicion) {
            $sql .= " AND posicion = ?";
            $params[] = $posicion;
        }
        
        $sql .= " ORDER BY precio DESC";
        return $this->db->executeQuery($sql, $params);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // obtenerJornadas()
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // SELECT * FROM jornadas
    // WHERE estado = 'Abierta' AND slots_max > 0
    // ORDER BY numero ASC
    // Si empty → return false
    // Si no   → return $resultado
    // ─────────────────────────────────────────────────────────────────────────
    public function obtenerJornadas() {
        $sql = "SELECT * FROM jornadas ORDER BY numero DESC";
        return $this->db->executeQuery($sql);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // obtenerJugadorPorID($id)
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // SELECT * FROM jugadores_reales WHERE id = ?
    // Pasar [$id] como parámetro
    // Si empty → return false
    // Si no   → return $resultado  (array completo, NO $resultado[0])
    //           porque la vista accede con $jugador[0]['nombre']
    // ─────────────────────────────────────────────────────────────────────────
    public function obtenerJugadorPorID($id) {
        $sql = "SELECT * FROM jugadores_reales WHERE id = ?";
        return $this->db->executeQuery($sql, [$id]);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // obtenerPlantillaManager($cod_manager)
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // SELECT p.id, p.fecha_fichaje, p.estado AS estado_fichaje,
    //        j.nombre AS nombre_jugador, j.posicion, j.club,
    //        j.precio, j.puntos_media,
    //        jor.numero AS numero_jornada
    // FROM plantilla p
    // INNER JOIN jugadores_reales j   ON p.id_jugador = j.id
    // INNER JOIN jornadas         jor ON p.id_jornada = jor.id
    // WHERE p.cod_manager = ?
    //   AND p.estado = 'Activo'
    // ORDER BY p.fecha_fichaje DESC
    // ─────────────────────────────────────────────────────────────────────────
    public function obtenerPlantillaManager($cod_manager) {
        $sql = "SELECT p.id, p.fecha_fichaje, p.estado AS estado_fichaje,
                j.nombre AS nombre_jugador, j.posicion, j.club,
                j.precio, j.puntos_media,
                jor.numero AS numero_jornada
                FROM plantilla p
                INNER JOIN jugadores_reales j   ON p.id_jugador = j.id
                INNER JOIN jornadas         jor ON p.id_jornada = jor.id
                WHERE p.cod_manager = ?
                AND p.estado = 'Activo'
                ORDER BY p.fecha_fichaje DESC";
        return $this->db->executeQuery($sql, [$cod_manager]);
    }


    // ─────────────────────────────────────────────────────────────────────────
    // confirmarFichaje($cod_manager, $id_jugador, $id_jornada)
    // ─────────────────────────────────────────────────────────────────────────
    // TODO: TRANSACCIÓN con 3 pasos
    // $this->db->beginTransaction()
    //
    // PASO 1 — INSERT en plantilla:
    //   INSERT INTO plantilla (cod_manager, id_jugador, id_jornada, estado)
    //   VALUES (?, ?, ?, 'Activo')
    //   Si $filas !== 1 → rollback + return false
    //
    // PASO 2 — UPDATE jugador a 'Fichado':
    //   UPDATE jugadores_reales SET estado = 'Fichado' WHERE id = ?
    //   Si $filas !== 1 → rollback + return false
    //
    // PASO 3 — Decrementar slot de la jornada:
    //   UPDATE jornadas SET slots_max = slots_max - 1
    //   WHERE id = ? AND slots_max > 0
    //   Si $filas !== 1 → rollback + return false
    //
    // $this->db->commit()
    // return true
    // ─────────────────────────────────────────────────────────────────────────
    public function confirmarFichaje($cod_manager, $id_jugador, $id_jornada) {
        try {
            $this->db->beginTransaction();

            // 1. Verificar si hay huecos en la jornada
            $sqlJornada = "SELECT slots_max FROM jornadas WHERE id = ? FOR UPDATE";
            $resJornada = $this->db->executeQuery($sqlJornada, [$id_jornada]);
            if (empty($resJornada) || (int)$resJornada[0]['slots_max'] <= 0) {
                throw new \Exception("No quedan huecos en esta jornada");
            }

            // 2. Verificar si el jugador sigue disponible
            $sqlJugador = "SELECT estado FROM jugadores_reales WHERE id = ? FOR UPDATE";
            $resJugador = $this->db->executeQuery($sqlJugador, [$id_jugador]);
            if (empty($resJugador) || $resJugador[0]['estado'] !== 'Disponible') {
                throw new \Exception("El jugador ya no está disponible");
            }

            // 3. Insertar en plantilla
            $sqlInsert = "INSERT INTO plantilla (cod_manager, id_jugador, id_jornada, estado)
                          VALUES (?, ?, ?, 'Activo')";
            $this->db->executeUpdate($sqlInsert, [$cod_manager, $id_jugador, $id_jornada]);

            // 4. Marcar jugador como fichado
            $sqlUpdateJugador = "UPDATE jugadores_reales SET estado = 'Fichado' WHERE id = ?";
            $this->db->executeUpdate($sqlUpdateJugador, [$id_jugador]);

            // 5. Restar un hueco a la jornada
            $sqlUpdateJornada = "UPDATE jornadas SET slots_max = slots_max - 1 WHERE id = ?";
            $this->db->executeUpdate($sqlUpdateJornada, [$id_jornada]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollback();
            return false;
        }
    }


    // ─────────────────────────────────────────────────────────────────────────
    // liberarJugador($id_plantilla)
    // ─────────────────────────────────────────────────────────────────────────
    // TODO:
    // Primero SELECT para obtener id_jugador e id_jornada:
    //   SELECT id_jugador, id_jornada FROM plantilla
    //   WHERE id = ? AND estado = 'Activo'
    //   Si empty → return false
    //
    // Guardar $id_jugador y $id_jornada del resultado[0]
    //
    // $this->db->beginTransaction()
    //
    // PASO 1 — Marcar fichaje como 'Cancelado':
    //   UPDATE plantilla SET estado = 'Cancelado' WHERE id = ?
    //   Si $filas !== 1 → rollback + return false
    //
    // PASO 2 — Devolver jugador a 'Disponible':
    //   UPDATE jugadores_reales SET estado = 'Disponible' WHERE id = ?
    //   Si $filas !== 1 → rollback + return false
    //
    // PASO 3 — Devolver slot a la jornada:
    //   UPDATE jornadas SET slots_max = slots_max + 1 WHERE id = ?
    //   Si $filas !== 1 → rollback + return false
    //
    // $this->db->commit()
    // return true
    // ─────────────────────────────────────────────────────────────────────────
    public function liberarJugador($id_plantilla) {
        try {
            $this->db->beginTransaction();

            // 1. Obtener datos del fichaje
            $sql = "SELECT id_jugador, id_jornada FROM plantilla
                    WHERE id = ? AND estado = 'Activo' FOR UPDATE";
            $resultado = $this->db->executeQuery($sql, [$id_plantilla]);
            if (empty($resultado)) {
                throw new \Exception("Fichaje no encontrado");
            }
            $id_jugador = $resultado[0]['id_jugador'];
            $id_jornada = $resultado[0]['id_jornada'];

            // 2. Cancelar el fichaje
            $sqlCancel = "UPDATE plantilla SET estado = 'Cancelado' WHERE id = ?";
            $this->db->executeUpdate($sqlCancel, [$id_plantilla]);

            // 3. Devolver jugador al mercado
            $sqlLib = "UPDATE jugadores_reales SET estado = 'Disponible' WHERE id = ?";
            $this->db->executeUpdate($sqlLib, [$id_jugador]);

            // 4. Devolver hueco a la jornada
            $sqlSlot = "UPDATE jornadas SET slots_max = slots_max + 1 WHERE id = ?";
            $this->db->executeUpdate($sqlSlot, [$id_jornada]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollback();
            return false;
        }
    }
}
