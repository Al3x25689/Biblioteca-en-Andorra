<?php

class Libro {

    private $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function all() {
        return $this->db->query("
            SELECT l.*, 
                   a.nombre AS autor, 
                   c.nombre AS categoria
            FROM libros l
            LEFT JOIN autores a ON l.autor_id = a.id
            LEFT JOIN categorias c ON l.categoria_id = c.id
            ORDER BY l.titulo
        ")->fetchAll();
    }

    public function disponibles() {
        $stmt = $this->db->query("
            SELECT * FROM libros WHERE cantidad > 0 ORDER BY titulo
        ");
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("
            SELECT * FROM libros WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    private function generarIniciales($titulo) {
        $palabras = explode(" ", $titulo);
        $ini = "";

        foreach ($palabras as $p) {
            if (strlen($p) > 0) {
                $ini .= strtoupper($p[0]);
            }
        }

        return substr($ini, 0, 3);
    }

    private function generarCodigo($titulo) {

        $ini = $this->generarIniciales($titulo);

        $stmt = $this->db->prepare("
            SELECT codigo 
            FROM libros 
            WHERE codigo LIKE ?
            ORDER BY codigo DESC
            LIMIT 1
        ");
        $stmt->execute([$ini . '%']);
        $ultimo = $stmt->fetchColumn();

        if ($ultimo) {

            $num = intval(substr($ultimo, strlen($ini) + 1)) + 1;
        } else {
            $num = 1;
        }

        return $ini . "-" . str_pad($num, 3, "0", STR_PAD_LEFT);
    }

    public function save($data, $filename = null) {

        if (!empty($data["id"])) {

            $sql = "UPDATE libros SET 
                        titulo       = ?, 
                        autor_id     = ?, 
                        categoria_id = ?, 
                        cantidad     = ?, 
                        portada      = ?
                    WHERE id = ?";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                $data["titulo"],
                $data["autor_id"],
                $data["categoria_id"],
                $data["cantidad"],
                $filename,
                $data["id"]
            ]);

        } else {

            $codigo = $this->generarCodigo($data["titulo"]);

            $sql = "INSERT INTO libros 
                    (codigo, titulo, autor_id, categoria_id, cantidad, portada)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                $codigo,
                $data["titulo"],
                $data["autor_id"],
                $data["categoria_id"],
                $data["cantidad"],
                $filename
            ]);
        }
    }

    public function disminuirCantidad($id) {
        $stmt = $this->db->prepare("
            UPDATE libros 
            SET cantidad = cantidad - 1 
            WHERE id = ? AND cantidad > 0
        ");
        return $stmt->execute([$id]);
    }

    public function aumentarCantidad($id) {
        $stmt = $this->db->prepare("
            UPDATE libros 
            SET cantidad = cantidad + 1 
            WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }
}
