<fieldset>
    <legend><h4>Témák</h4></legend>
    <?php if (empty($topics)): ?>
        <p>Még nincs egy téma sem</p>
    <?php else: ?>
        <?php foreach ($topics as $topic): ?>
            <p>
                <a href="/posts/list/<?= $topic['id'] ?>"><?= $topic['title'] ?></a> - <?= date('Y.m.d H:i', strtotime($topic['created_at'])) ?>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/site/delete/<?= $topic['id'] ?>">Törlés</a>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <?php if (isset($errors['delete'])): ?>
            <div><?= $errors['delete'] ?></div>
        <?php endif; ?>
    <?php endif; ?>
</fieldset>
<fieldset>
    <legend><h4>Téma létrehozása</h4></legend>
    <?php if (isset($_SESSION['user'])): ?>
        <form method="post">
            megnevezés:<br>
            <input type="title" name="topic[title]" value="<?= isset($form_values['title']) ? $form_values['title'] : '' ?>"><br>
            <?php if (isset($errors['title'])): ?>
                <div><?= $errors['title'] ?></div>
            <?php endif; ?>
            <br>
            <input type="submit" value="Mentés">
        </form>
    <?php else: ?>
        Téma hozzáadásához kérlek jelentkezz be <a href="/site/login">Bejelentkezés</a>
    <?php endif; ?>
</fieldset>
