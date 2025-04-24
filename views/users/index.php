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
    <p><a href="/posts">Ver todas las publicaciones</a></p>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <a href="/posts/show/<?php echo $user['id']; ?>">Ver publicaciones</a>
                <a href="/posts/create/<?php echo $user['id']; ?>">Crear publicación</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>