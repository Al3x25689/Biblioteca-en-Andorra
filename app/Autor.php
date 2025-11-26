<?php

class Autor {

    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function all() {
        $stmt = $this->db->query("SELECT * FROM autores ORDER BY nombre");
        return $stmt->fetchAll();
    }
}
