<?php
require_once "../app/Database.php";
require_once "../app/Prestamo.php";

$db = Database::getInstance();
$pdo = $db->getConnection();
$model = new Prestamo($pdo);

$id = $_GET["id"];

// devolver = eliminar + regresar cantidad
$model->delete($id);

header("Location: prestamos.php");
exit;
