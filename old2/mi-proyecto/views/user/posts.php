<?php require 'views/layout/header.php'; ?>

<h2>Publicaciones de <?= $user['name']; ?></h2>
<a href="index.php">Volver</a>
<ul>
    <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $post): ?>
            <li><strong><?= $post['title']; ?></strong>: <?= $post['content']; ?></li>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay publicaciones.</p>
    <?php endif; ?>
</ul>

<?php require 'views/layout/footer.php'; ?>
