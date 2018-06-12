<fieldset>
    <legend><h4>Regisztráció</h4></legend>
    <form method="post">
        Név:<br>
        <input type="text" name="registration[name]" value="<?= isset($form_values['name']) ? $form_values['name'] : '' ?>"><br>
        <?php if (isset($errors['name'])): ?>
            <div><?= $errors['name'] ?></div>
        <?php endif; ?>
        E-mail:<br>
        <input type="text" name="registration[email]" value="<?= isset($form_values['email']) ? $form_values['email'] : '' ?>"><br>
        <?php if (isset($errors['email'])): ?>
            <div><?= $errors['email'] ?></div>
        <?php endif; ?>
        Jelszó:<br>
        <input type="password" name="registration[password]" value="<?= isset($form_values['password']) ? $form_values['password'] : '' ?>"><br>
        <?php if (isset($errors['password'])): ?>
            <div><?= $errors['password'] ?></div>
        <?php endif; ?>
        <label>Jelszó újra:</label><br>
        <input type="password" name="registration[repeat_password]" value="<?= isset($form_values['repeat_password']) ? $form_values['repeat_password'] : '' ?>"><br>
        <?php if (isset($errors['repeat_password'])): ?>
            <div><?= $errors['repeat_password'] ?></div>
        <?php endif; ?>
        <input type="submit" value="Regisztráció">
    </form>
</fieldset>
<br>
<a href="/site/index">Vissza</a>