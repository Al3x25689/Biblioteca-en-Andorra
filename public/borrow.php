<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Prestamo.php';
require_once __DIR__ . '/../app/Usuario.php';
require_once __DIR__ . '/../app/Libro.php';

$db = Database::getInstance();
$pdo = $db->getConnection();

$libroModel = new Libro($pdo);
$usuarioModel = new Usuario($pdo);
$prestamoModel = new Prestamo($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libro_id = (int)$_POST['libro_id'];
    $usuario_id = (int)$_POST['usuario_id'] ?: null;
    $fecha = $_POST['fecha_prestamo'] ?? date('Y-m-d');

    $ok = $prestamoModel->crearPrestamo($libro_id, $usuario_id, $fecha);
    header('Location: loans.php');
    exit;
}

$libros = $libroModel->all();
$usuarios = $usuarioModel->all();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Prestar libro</title></head>
<body>
<h2>Prestar libro</h2>
<form method="post">
    <label>Libro:</label>
    <select name="libro_id" required>
        <?php foreach($libros as $l): if($l['estado']=='disponible'): ?>
            <option value="<?= $l['id'] ?>"><?= htmlspecialchars($l['titulo']) ?> (<?= $l['autor'] ?>)</option>
        <?php endif; endforeach; ?>
    </select><br>
    <label>Usuario:</label>
    <select name="usuario_id">
        <option value="">(Sin usuario)</option>
        <?php foreach($usuarios as $u): ?>
            <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Fecha:</label>
    <input type="date" name="fecha_prestamo" value="<?= date('Y-m-d') ?>"><br>
    <input type="submit" value="Prestar">
</form>
</body>
</html>
