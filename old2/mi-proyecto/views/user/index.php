<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-inter">
    <div class="container mx-auto p-6 sm:p-10 md:p-12 lg:p-16">
        <h1 class="text-2xl font-semibold text-blue-600 mb-8 text-center">Lista de Usuarios</h1>
        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Nombre</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="4" class="px-5 py-5 border-b border-gray-200 text-sm text-gray-500 text-center">No hay usuarios registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm"><span class="font-italic text-gray-800"><?php echo $usuario['id']; ?></span></td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm"><span class="font-semibold text-blue-700"><?php echo htmlspecialchars($usuario['name']); ?></span></td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm"><span class="text-gray-900"><?php echo htmlspecialchars($usuario['email']); ?></span></td>
                                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                                    <div class="flex space-x-2">
                                        <a href="index.php?action=posts&user_id=<?= $usuario['id'] ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Ver publicaciones</a>
                                        <a href="index.php?action=create_post&user_id=<?= $usuario['id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear publicación</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
