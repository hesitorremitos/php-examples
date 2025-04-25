<!-- views/registro_usuario.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .error { color: red; font-size: 0.9em; }
        .success { color: green; font-size: 0.9em; }
        form { margin-top: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-bottom: 10px; box-sizing: border-box; }
        button { padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>Registro de Nuevo Usuario</h2>

    <!-- Mostrar mensaje de éxito -->
    <?php if (isset($_SESSION['mensaje_exito'])): ?>
        <p class="success"><?php echo htmlspecialchars($_SESSION['mensaje_exito']); ?></p>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <!-- Mostrar mensaje de error general -->
    <?php if (isset($_SESSION['mensaje_error'])): ?>
        <p class="error"><?php echo htmlspecialchars($_SESSION['mensaje_error']); ?></p>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php elseif (!empty($datos['errores']['general'])): ?>
        <p class="error"><?php echo htmlspecialchars($datos['errores']['general']); ?></p>
    <?php endif; ?>

    <form action="index.php?accion=registrar" method="POST">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($datos['nombre'] ?? ''); ?>" required>
            <?php if (!empty($datos['errores']['nombre'])): ?>
                <p class="error"><?php echo htmlspecialchars($datos['errores']['nombre']); ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($datos['email'] ?? ''); ?>" required>
            <?php if (!empty($datos['errores']['email'])): ?>
                <p class="error"><?php echo htmlspecialchars($datos['errores']['email']); ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>
            <?php if (!empty($datos['errores']['contrasena'])): ?>
                <p class="error"><?php echo htmlspecialchars($datos['errores']['contrasena']); ?></p>
            <?php endif; ?>
        </div>

        <button type="submit">Registrarse</button>
    </form>

    <p><a href="index.php">Volver al inicio</a></p>
</body>
</html>