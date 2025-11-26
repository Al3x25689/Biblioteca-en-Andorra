<?php
require_once "../app/Database.php";
require_once "../app/Prestamo.php";

$db = Database::getInstance();
$pdo = $db->getConnection();
$model = new Prestamo($pdo);

$prestamos = $model->all();
?>

<h2>Préstamos</h2>

    <?php include "header.php"; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Libro</th>
        <th>Portada</th>
        <th>Usuario</th>
        <th>Fecha Préstamo</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($prestamos as $p): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['titulo'] ?></td>
        <td><img src="uploads/<?= $p['portada'] ?>" width="40"></td>
        <td><?= $p['usuario'] ?></td>
        <td><?= $p['fecha_prestamo'] ?></td>
        <td>
            <a href="devolver_prestamo.php?id=<?= $p['id'] ?>">Devolver</a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<?php include "footer.php"; ?>
