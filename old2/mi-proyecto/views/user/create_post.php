<?php require 'views/layout/header.php'; ?>

<h2>Crear Publicación</h2>
<form action="index.php?action=store_post" method="POST">
    <input type="hidden" name="user_id" value="<?= $_GET['user_id']; ?>">
    <label>Título:</label><br>
    <input type="text" name="title" required><br><br>
    <label>Contenido:</label><br>
    <textarea name="content" required></textarea><br><br>
    <button type="submit">Guardar</button>
</form>
<a href="index.php">Volver</a>

<?php require 'views/layout/footer.php'; ?>
