<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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
        .usuarios-table {
            margin-top: 40px;
        }
        .usuarios-table th, .usuarios-table td {
            text-align: center;
        }
        .acciones-usuarios button {
            margin: 5px;
            cursor: pointer;
        }
        .mensaje {
            padding: 10px;
            background-color: #dff0d8;
            color: #3c763d;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2 class="usuarios-table">Lista de Usuarios</h2>

    <?php if (!empty($datos['usuarios'])): ?>
        <table class="usuarios-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($datos['usuarios'] as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['id']) ?></td>
                        <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td class="acciones-usuarios">
                            <form method="get" style="display:inline;">
                                <input type="hidden" name="accion" value="ver_publicaciones">
                                <input type="hidden" name="user_id" value="<?= $usuario['id'] ?>">
                                <button type="submit">Ver publicaciones</button>
                            </form>
                            <form method="get" style="display:inline;">
                                <input type="hidden" name="accion" value="crear_publicacion_form">
                                <input type="hidden" name="user_id" value="<?= $usuario['id'] ?>">
                                <button type="submit">Crear publicación</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="usuarios-table">No hay usuarios registrados</p>
    <?php endif; ?>

    <?php if (!empty($_SESSION['mensaje_exito_publicacion'])): ?>
        <div class="mensaje">
            <?= $_SESSION['mensaje_exito_publicacion']; unset($_SESSION['mensaje_exito_publicacion']); ?>
        </div>
    <?php endif; ?>

    <p><a href="?accion=registrar">Volver al registrar usuarios</a></p>
</body>
</html>