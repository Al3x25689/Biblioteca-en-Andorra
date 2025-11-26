<?php
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Prestamo.php';

$db = Database::getInstance();
$pdo = $db->getConnection();

$prestamoModel = new Prestamo($pdo);
$prestamos = $prestamoModel->all();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Préstamos</title></head>
<body>
<h2>Préstamos</h2>
<table border="1">
<thead><tr><th>ID</th><th>Libro</th><th>Usuario</th><th>Fecha préstamo</th><th>Fecha devolución</th><th>Estado</th><th>Acciones</th></tr></thead>
<tbody>
<?php foreach($prestamos as $p): ?>
<tr>
  <td><?= $p['id'] ?></td>
  <td><?= htmlspecialchars($p['titulo']) ?></td>
  <td><?= htmlspecialchars($p['usuario']) ?></td>
  <td><?= $p['fecha_prestamo'] ?></td>
  <td><?= $p['fecha_devolucion'] ?></td>
  <td><?= $p['estado'] ?></td>
  <td>
    <?php if($p['estado'] === 'activo'): ?>
      <a href="return.php?id=<?= $p['id'] ?>">Devolver</a>
    <?php endif; ?>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>
