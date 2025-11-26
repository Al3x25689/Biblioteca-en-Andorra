<?php
require_once "../app/Database.php";
require_once "../app/Libro.php";
require_once "../app/Prestamo.php";

$db = Database::getInstance();
$pdo = $db->getConnection();

$libroModel = new Libro($pdo);
$prestamoModel = new Prestamo($pdo);

$libros = $libroModel->disponibles();
?>

<h2 class="titulo-centro">Registrar Préstamo</h2>

    <?php include "header.php"; ?>
<div class="form-container">

    <form method="POST" action="save_prestamo.php">

        <label>Libro:</label>
        <select name="libro_id" required>
            <?php foreach ($libros as $l): ?>
                <option value="<?= $l['id'] ?>">
                    <?= $l['titulo'] ?> (<?= $l['cantidad'] ?> disponibles)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <input type="submit" value="Registrar Préstamo">
    </form>
</div>

<?php include "footer.php"; ?>
