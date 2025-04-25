<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicaciones del Usuario</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Publicaciones del Usuario</h2>

    <?php if (!empty($publicaciones)): ?>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Contenido</th>
                    <th>Creado en</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($publicaciones as $publicacion): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($publicacion['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($publicacion['content'])); ?></td>
                        <td><?php echo $publicacion['created_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Este usuario no tiene publicaciones.</p>
    <?php endif; ?>

    <p><a href="/">Volver a la lista de usuarios</a></p>
    <p><a href="index.php?accion=ver_libros">Ver Lista de Libros</a></p>
    <p><a href="?accion=inicio">Volver al inicio</a></p>
</body>
</html>