<?php

class SiteController extends ControllerBase
{
    public function actionIndex()
    {
        $form_values = [];
        $errors = [];

        if (isset($_POST['topic']) && !empty($_POST['topic'])) {
            $data = $_POST['topic'];
            if ($data['title'] == '') {
                $errors['title'] = 'A cím nem lehet üres';
            }
            if (empty($errors)) {
                $stmt = $this->pdo->prepare("INSERT INTO topics SET `title`=:title");
                if ($stmt->execute(['title' => $data['title']])) {
                    $this->redirect('/site/index');
                }
            }
            $form_values = [
                'title' => $data['title'],
            ];
        }

        $topics = $this->pdo->query('SELECT * FROM topics ORDER BY created_at ASC')->fetchAll(PDO::FETCH_ASSOC);
        echo $this->render('index', [
            'topics' => $topics,
            'errors' => $errors,
            'form_values' => $form_values,
        ]);
    }

    public function actionDelete($topicId)
    {
        $form_values = [];
        $errors = [];

        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE `topic_id`=:topic_id");
        if ($stmt->execute(['topic_id' => $topicId])) {
            $stmt2 = $this->pdo->prepare("DELETE FROM topics WHERE `id`=:topic_id");
            if ($stmt2->execute(['topic_id' => $topicId])) {
                $this->redirect('/site/index');
            }
        } else {
            $errors['delete'] = 'Nem sikerült a törlési művelet!';
        }

        echo $this->render('index', [
            'topics' => $this->pdo->query('SELECT * FROM topics ORDER BY created_at ASC')->fetchAll(PDO::FETCH_ASSOC),
            'errors' => $errors,
            'form_values' => $form_values,
        ]);
    }

    public function actionLogin()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/site/index');
        }

        $this->setLayout('login');
        $form_values = [];
        $errors = [];
        if (isset($_POST['login']) && !empty($_POST['login'])) {
            $data = $_POST['login'];
            if ($data['email'] == '') {
                $errors['email'] = 'E-mail cím nem lehet üres';
            }
            if ($data['password'] == '') {
                $errors['password'] = 'Jelszó nem lehet üres';
            }
            if (empty($errors)) {
                $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
                $stmt->execute(['email' => $data['email']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($user) && $user['password'] == sha1($data['password'])) {
                    $_SESSION['user'] = $user;
                    $this->redirect('/site/index');
                } else {
                    $errors['password'] = 'Rossz e-mail cím vagy jelszó';
                }
            }
            $form_values = [
                'email' => $data['email'],
                'password' => $data['password'],
            ];
        }
        echo $this->render('login', [
            'errors' => $errors,
            'form_values' => $form_values,
        ]);
    }

    public function actionRegistration()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/site/index');
        }

        $form_values = [];
        $errors = [];
        if (isset($_POST['registration']) && !empty($_POST['registration'])) {
            $data = $_POST['registration'];
            if ($data['email'] == '') {
                $errors['email'] = 'E-mail cím nem lehet üres';
            } else {
                $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
                $stmt->execute(['email' => $data['email']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($user)) {
                    $errors['email'] = 'Ez az e-mail cím már foglalt';
                }
            }
            if ($data['password'] == '') {
                $errors['password'] = 'Jelszó nem lehet üres';
            }
            if ($data['repeat_password'] == '') {
                $errors['repeat_password'] = 'Jelszó nem lehet üres';
            } else {
                if ($data['password'] != $data['repeat_password']) {
                    $errors['repeat_password'] = 'Jelszavak nem egyeznek';
                }
            }
            if ($data['name'] == '') {
                $errors['name'] = 'Név nem lehet üres';
            }

            if (empty($errors)) {
                $stmt = $this->pdo->prepare("INSERT INTO users SET `name`=:name, `email`=:email, `password`=:password");
                if ($stmt->execute(['name' => $data['name'], 'email' => $data['email'], 'password' => sha1($data['password'])])) {
                    $this->redirect('/site/index');
                }
            }
            $form_values = [
                'email' => $data['email'],
                'password' => $data['password'],
                'repeat_password' => $data['repeat_password'],
                'name' => $data['password'],
            ];
        }
        echo $this->render('registration', [
            'errors' => $errors,
            'form_values' => $form_values,
        ]);
    }

    public function actionLogout()
    {
        session_destroy();
        $this->redirect('/site/index');
    }

}
