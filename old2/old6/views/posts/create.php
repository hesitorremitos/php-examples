<!DOCTYPE html>
<html>
<head>
    <title>Crear Publicación</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Crear Publicación</h1>
    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    <form action="/posts/store" method="POST">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <label>Título:</label><br>
        <input type="text" name="title" required><br>
        <label>Contenido:</label><br>
        <textarea name="content" required></textarea><br>
        <button type="submit">Guardar</button>
    </form>
    <a href="/">Volver</a>
</body>
</html>