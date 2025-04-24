<!DOCTYPE html>
<html>
<head>
    <title>Publicaciones</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Publicaciones del usuario</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>
    <?php if (empty($posts)): ?>
        <p>No hay publicaciones.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><?php echo $post['title']; ?></h3>
                    <p><?php echo $post['content']; ?></p>
                    <small>Creado: <?php echo $post['created_at']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="/">Volver</a>
</body>
</html>