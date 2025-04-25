<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Libros</title>
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
            font-weight: bold;
        }
        caption {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .no-data {
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>📚 Lista de Libros Disponibles</h2>
    <?php if (isset($datos['libros']) && is_array($datos['libros']) && !empty($datos['libros'])): ?>
        <table>
            <caption>Catálogo de Libros</caption>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Género</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos['libros'] as $libro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($libro['titulo'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($libro['autor'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($libro['año_publicacion'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($libro['genero'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-data">😞 No hay libros disponibles en este momento.</p>
    <?php endif; ?>
    <p><a href="?accion=registrar">Volver al registrar usuarios</a></p>
</body>
</html>