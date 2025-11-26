<?php
require_once "../app/Database.php";
require_once "../app/Libro.php";

$pagetitle = "Listado de Libros";

$db = Database::getInstance();
$pdo = $db->getConnection();
$libroModel = new Libro($pdo);

$libros = $libroModel->all();

?>

<div class="page-container">

    <h2 class="titulo-centro">Listado de Libros</h2>

    <?php include "header.php"; ?>

    <div class="tabla-centro">
        <table>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Portada</th>
                <th>Acciones</th>
            </tr>

            <?php foreach ($libros as $l): ?>
            <tr>
                <td><?= $l['codigo'] ?></td>
                <td><?= $l['titulo'] ?></td>
                <td><?= $l['autor'] ?></td>
                <td><?= $l['categoria'] ?></td>
                <td><?= $l['cantidad'] ?></td>
                <td><img src="uploads/<?= $l['portada'] ?>" width="60"></td>
                <td>
                    <a href="book_form.php?id=<?= $l['id'] ?>">Editar</a> |
                    <a href="delete_book.php?id=<?= $l['id'] ?>">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>

</div>

<?php include "footer.php"; ?>
