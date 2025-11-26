<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Prestamo.php';

$db = Database::getInstance();
$pdo = $db->getConnection();

$prestamoModel = new Prestamo($pdo);

if (!isset($_GET['id'])) {
    header('Location: loans.php'); exit;
}

$id = (int)$_GET['id'];
$ok = $prestamoModel->devolver($id, date('Y-m-d'));
header('Location: loans.php');
exit;
