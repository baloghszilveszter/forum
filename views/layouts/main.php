<!DOCTYPE html>
<html>
<head>
    <title>Fórum</title>
</head>
<body>
    <?php if (isset($_SESSION['user'])): ?>
        <p>
            <b>Szia, <?= $_SESSION['user']['name'] ?>!</b> <a href="/site/logout">Kijelentkezés</a>
        </p>
    <?php endif; ?>
    <div><?= $content ?></div>
</body>
</html>