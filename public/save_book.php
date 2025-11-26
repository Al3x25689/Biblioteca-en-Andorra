<?php
require_once "../app/Database.php";
require_once "../app/Libro.php";

$db = Database::getInstance();
$pdo = $db->getConnection();

$libroModel = new Libro($pdo);

$data = [
    "id"            => $_POST["id"] ?? null,
    "titulo"        => $_POST["titulo"],
    "autor_id"      => $_POST["autor_id"],
    "categoria_id"  => $_POST["categoria_id"],
    "cantidad"      => $_POST["cantidad"],
    "portada_old"   => $_POST["portada_old"] ?? null
];

$filename = $data["portada_old"];

if (!empty($_FILES["portada"]["name"])) {
    $filename = time() . "_" . $_FILES["portada"]["name"];
    move_uploaded_file($_FILES["portada"]["tmp_name"], "uploads/" . $filename);
}

$libroModel->save($data, $filename);

header("Location: libros.php");
exit;
