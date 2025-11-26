<?php
require_once __DIR__ . '/../app/Database.php';

$db = Database::getInstance();
$pdo = $db->getConnection();

if (!isset($_GET['id'])) {
    die("ID no recibido");
}

$id = (int)$_GET['id'];

$sql = "DELETE FROM libros WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: index.php");
exit;
