<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <h1>¡Ups! Algo salió mal</h1>
    <p><?php if (isset($error)) echo htmlspecialchars($error); ?></p>
    <p><a href="?accion=inicio">Volver al inicio</a></p>
</body>
</html>