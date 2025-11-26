<?php
require_once "../app/Database.php";
require_once "../app/Libro.php";
require_once "../app/Autor.php";
require_once "../app/Categoria.php";

$db = Database::getInstance();
$pdo = $db->getConnection();

$libroModel = new Libro($pdo);
$autorModel = new Autor($pdo);
$categoriaModel = new Categoria($pdo);

$id = $_GET['id'] ?? null;
$libro = $id ? $libroModel->find($id) : null;

$autores = $autorModel->all();
$categorias = $categoriaModel->all();
?>

<h2 class="titulo-centro"><?= $id ? "Editar Libro" : "Agregar Libro" ?></h2>

    <?php include "header.php"; ?>

<div class="form-container">

    <form action="save_book.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $libro['id'] ?? '' ?>">
        <input type="hidden" name="portada_old" value="<?= $libro['portada'] ?? '' ?>">

        <label>Título:</label>
        <input type="text" name="titulo" required value="<?= $libro['titulo'] ?? '' ?>">

        <label>Autor:</label>
        <select name="autor_id" required>
            <option value="">Seleccione...</option>
            <?php foreach ($autores as $a): ?>
                <option value="<?= $a['id'] ?>"
                    <?= isset($libro['autor_id']) && $libro['autor_id'] == $a['id'] ? "selected" : "" ?>>
                    <?= $a['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Categoría:</label>
        <select name="categoria_id" required>
            <option value="">Seleccione...</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= isset($libro['categoria_id']) && $libro['categoria_id'] == $c['id'] ? "selected" : "" ?>>
                    <?= $c['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" min="1" required value="<?= $libro['cantidad'] ?? 1 ?>">

        <label>Portada:</label>
        <input type="file" name="portada">

        <?php if ($libro && $libro['portada']): ?>
            <img src="uploads/<?= $libro['portada'] ?>" width="80">
        <?php endif; ?>

        <input type="submit" value="Guardar">
    </form>
</div>

<?php include "footer.php"; ?>
