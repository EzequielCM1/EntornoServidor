<?php

namespace Ezequiel\Lib;

use mysqli;

require_once __DIR__ . "/db_credentials.php";

class Database {

    private $conn;
    public $error;

    public function __construct() {
        $this->conn = new mysqli(BD_HOST, BD_USER, BD_PASS, BD_NAME);
        if ($this->conn->connect_error) {
            die("Error fatal de conexión: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    private function tipoParametro($value): string {
        if (is_int($value))   return 'i';
        if (is_float($value)) return 'd';
        if (is_bool($value))  return 'i';
        if (is_null($value))  return 's';
        return 's';
    }

    public function executeQuery($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) { $this->error = $this->conn->error; return false; }

        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) $types .= $this->tipoParametro($param);
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        if ($stmt->error) { $this->error = $stmt->error; $stmt->close(); return false; }

        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    public function executeUpdate($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) { $this->error = $this->conn->error; return false; }

        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) $types .= $this->tipoParametro($param);
            $stmt->bind_param($types, ...$params);
        }

        $success = $stmt->execute();
        if (!$success) { $this->error = $stmt->error; $stmt->close(); return false; }

        $filas = $stmt->affected_rows;
        $stmt->close();
        return $filas;
    }

    public function beginTransaction() { return $this->conn->begin_transaction(); }
    public function commit()           { return $this->conn->commit(); }
    public function rollback()         { return $this->conn->rollback(); }
    public function getLastInsertId()  { return $this->conn->insert_id; }
    public function close()            { $this->conn->close(); }
}
