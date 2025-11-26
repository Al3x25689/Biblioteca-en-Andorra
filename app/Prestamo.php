<?php

class Prestamo {

    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // -------------------------------------------------------
    // LISTAR TODOS LOS PRÉSTAMOS (JOIN CON LIBROS)
    // -------------------------------------------------------
    public function all() {
        $sql = "
            SELECT p.*, 
                   l.titulo, 
                   l.portada
            FROM prestamos p
            INNER JOIN libros l ON p.libro_id = l.id
            ORDER BY p.fecha_prestamo DESC
        ";

        return $this->db->query($sql)->fetchAll();
    }

    // -------------------------------------------------------
    // BUSCAR UN PRÉSTAMO POR ID
    // -------------------------------------------------------
    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM prestamos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // -------------------------------------------------------
    // CREAR PRÉSTAMO + BAJAR CANTIDAD DEL LIBRO
    // -------------------------------------------------------
    public function save($data) {

        // 1️⃣ Verificar cantidad disponible
        $stmt = $this->db->prepare("SELECT cantidad FROM libros WHERE id = ?");
        $stmt->execute([$data["libro_id"]]);
        $libro = $stmt->fetch();

        if (!$libro || $libro["cantidad"] <= 0) {
            return false; // No disponible
        }

        // 2️⃣ Insertar préstamo
        $sql = "INSERT INTO prestamos (libro_id, usuario, fecha_prestamo)
                VALUES (?, ?, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data["libro_id"],
            $data["usuario"]
        ]);

        // 3️⃣ Bajar cantidad del libro
        $this->db->prepare("
            UPDATE libros SET cantidad = cantidad - 1 WHERE id = ?
        ")->execute([$data["libro_id"]]);

        return true;
    }

    // -------------------------------------------------------
    // ELIMINAR PRÉSTAMO (DEVOLVER)
    // -------------------------------------------------------
    public function delete($id) {

        // obtener libro_id antes de borrar
        $stmt = $this->db->prepare("SELECT libro_id FROM prestamos WHERE id = ?");
        $stmt->execute([$id]);
        $prestamo = $stmt->fetch();

        if (!$prestamo) {
            return false;
        }

        $libro_id = $prestamo["libro_id"];

        // borrar préstamo
        $stmt = $this->db->prepare("DELETE FROM prestamos WHERE id = ?");
        $stmt->execute([$id]);

        // aumentar cantidad del libro
        $this->db->prepare("
            UPDATE libros SET cantidad = cantidad + 1 WHERE id = ?
        ")->execute([$libro_id]);

        return true;
    }
}
