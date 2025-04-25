<!DOCTYPE html>
<html>
<head>
    <title>Publicaciones</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Publicaciones del usuario</h1>
    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php else: ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                    <small>Creado: <?php echo htmlspecialchars($post['created_at']); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="/">Volver</a>
</body>
</html>