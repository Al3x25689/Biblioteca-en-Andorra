<?php
// app/Usuario.php
class Usuario {
    private $db;
    public function __construct(PDO $pdo){ $this->db = $pdo; }

    public function all(){
        $stmt = $this->db->query('SELECT * FROM usuarios ORDER BY nombre');
        return $stmt->fetchAll();
    }

    public function find($id){
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch();
    }

    public function create($nombre, $email = null){
        $stmt = $this->db->prepare('INSERT INTO usuarios (nombre, email) VALUES (:n, :e)');
        $stmt->execute([':n'=>$nombre, ':e'=>$email]);
        return $this->db->lastInsertId();
    }
}
