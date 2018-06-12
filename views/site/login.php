<fieldset>
    <legend><h4>Bejelentkezés</h4></legend>
    <form method="post">
        E-mail cím:<br>
        <input type="text" name="login[email]" value="<?= isset($form_values['email']) ? $form_values['email'] : '' ?>"><br>
        <?php if (isset($errors['email'])): ?>
            <div><?= $errors['email'] ?></div>
        <?php endif; ?>
        Jelszó:<br>
        <input type="password" name="login[password]" value="<?= isset($form_values['password']) ? $form_values['password'] : '' ?>"><br>
        <?php if (isset($errors['password'])): ?>
            <div><?= $errors['password'] ?></div>
        <?php endif; ?>
        <input type="submit" value="Belépés"> <a href="/site/registration">Regisztráció</a>
    </form>
</fieldset>
<br>
<a href="/site/index">Vissza</a