<!DOCTYPE html>
<html>
<head>
    <title>Lista de Publicaciones</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Todas las Publicaciones</h1>
    <?php if (empty($posts)): ?>
        <p>No hay publicaciones.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><?php echo $post['title']; ?></h3>
                    <p><?php echo $post['content']; ?></p>
                    <small>Por: <?php echo $post['username']; ?> | Creado: <?php echo $post['created_at']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="/">Volver a usuarios</a>
</body>
</html>