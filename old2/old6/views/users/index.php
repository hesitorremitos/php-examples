<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <h1>Usuarios</h1>
    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>
    <p><a href="/users/create">Crear nuevo usuario</a></p>
    <p><a href="/posts">Ver todas las publicaciones</a></p>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <a href="/posts/show/<?php echo $user['id']; ?>">Ver publicaciones</a>
                    <a href="/posts/create/<?php echo $user['id']; ?>">Crear publicación</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>