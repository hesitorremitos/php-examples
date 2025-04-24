<!DOCTYPE html>
<html>
<head>
    <title>Publicaciones del Usuario</title>
</head>
<body>
    <h1>Publicaciones del Usuario (ID: <?php echo $_GET['user_id'] ?? ''; ?>)</h1>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'publicacion_creada'): ?>
        <p style="color: green;">✅ Publicación creada exitosamente.</p>
    <?php endif; ?>

    <?php if (empty($publicaciones)): ?>
        <p>No hay publicaciones para este usuario.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($publicaciones as $publicacion): ?>
                <li>
                    <strong><?php echo htmlspecialchars($publicacion['title']); ?></strong>
                    <br>
                    <small>Creado el: <?php echo $publicacion['created_at']; ?></small>
                    <br>
                    <?php echo nl2br(htmlspecialchars($publicacion['content'])); ?>
                    <hr>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <br>
    <a href="index.php">Volver</a>
</body>
</html>