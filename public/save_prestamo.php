<?php
require_once "../app/Database.php";
require_once "../app/Prestamo.php";

$db = Database::getInstance();
$pdo = $db->getConnection();
$model = new Prestamo($pdo);

$data = [
    "usuario"  => $_POST["usuario"],
    "libro_id" => $_POST["libro_id"]
];

$model->save($data); // ← ESTA ES LA CORRECTA

header("Location: prestamos.php");
exit;
