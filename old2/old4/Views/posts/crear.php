<!DOCTYPE html>
<html>
<head>
    <title>Crear Publicación</title>
</head>
<body>
    <h1>Crear Nueva Publicación</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="index.php?accion=registrarPublicacion" method="post">
        <input type="hidden" name="user_id" value="<?php echo $_GET['user_id'] ?? ''; ?>">

        <div>
            <label for="title">Título:</label><br>
            <input type="text" id="title" name="title" required>
        </div>
        <br>
        <div>
            <label for="content">Contenido:</label><br>
            <textarea id="content" name="content" rows="5" cols="50" required></textarea>
        </div>
        <br>
        <button type="submit">Guardar Publicación</button>
    </form>

    <br>
    <a href="index.php">Volver</a>
</body>
</html>