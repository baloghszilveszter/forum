<h3>Téma: <?= $topic['title']?> </h3>
<?php if (!empty($errors)): ?>
<h2>
    <?php foreach ($errors as $error): ?>
        <?= $error ?>
    <?php endforeach; ?>
</h2>
<?php endif; ?>
<fieldset>
    <legend><h4>Hozzászólások</h4></legend>
    <?php if (empty($posts)): ?>
        <p>Még nincs a témában hozzászólás</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <p>
                <?= $post['comment'] ?> - <?= date('Y.m.d H:i', strtotime($post['created_at'])) ?> - <?= $post['user_name'] ?>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $post['user_id']): ?>
                    <a href="/posts/delete/<?= $post['id'] ?>">Törlés</a>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
        <?php if (isset($errors['delete'])): ?>
            <div><?= $errors['delete'] ?></div>
        <?php endif; ?>
    <?php endif; ?>
</fieldset>
<fieldset>
    <legend><h4>Hozzászólás létrehozása</h4></legend>
    <?php if (isset($_SESSION['user'])): ?>
        <form method="post">
            hozzászólásod:<br>
            <textarea cols="50" rows="10" name="post[comment]"><?= isset($form_values['comment']) ? $form_values['comment'] : '' ?></textarea><br>
            <?php if (isset($errors['comment'])): ?>
                <div><?= $errors['comment'] ?></div>
            <?php endif; ?>
            <br>
            <input type="submit" value="Mentés">
        </form>
    <?php else: ?>
        Hozzászólás létrehozásához kérlek jelentkezz be <a href="/site/login">Bejelentkezés</a>
    <?php endif; ?>
</fieldset>
<br>
<a href="/site/index">Vissza</a>
