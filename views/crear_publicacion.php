<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Publicación</title>
</head>
<body>
    <h2>Crear Nueva Publicación</h2>

    <form action="index.php?accion=crear_publicacion" method="post">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['user_id']); ?>">

        <div>
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <br>
        <div>
            <label for="content">Contenido:</label>
            <textarea id="content" name="content" rows="5" required></textarea>
        </div>
        <br>
        <button type="submit">Crear Publicación</button>
    </form>

    <p><a href="index.php?accion=ver_publicaciones&user_id=<?php echo htmlspecialchars($_GET['user_id']); ?>">Volver a mis publicaciones</a></p>
    <p><a href="?accion=inicio">Volver al inicio</a></p>
    <p><a href="index.php?accion=ver_libros">Ver Lista de Libros</a></p>
</body>
</html>