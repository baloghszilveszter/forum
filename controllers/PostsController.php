<?php

class PostsController extends ControllerBase
{
    public function actionList($topicId)
    {
        $form_values = [];
        $errors = [];

        if (isset($_POST['post']) && !empty($_POST['post'])) {
            $data = $_POST['post'];
            if ($data['comment'] == '') {
                $errors['comment'] = 'A hozzászólás nem lehet üres.';
            }
            if (empty($errors)) {
                $stmt = $this->pdo->prepare("INSERT INTO posts SET `comment`=:comment, `user_id`=:user_id, `topic_id`=:topic_id");
                if ($stmt->execute(['comment' => $data['comment'], 'user_id' => $_SESSION['user']['id'], 'topic_id' => $topicId])) {
                    $this->redirect('/posts/list/' . $topicId);
                }
            }
            $form_values = [
                'comment' => $data['comment'],
            ];
        }

        echo $this->render('list', [
            'posts' => $this->getPosts($topicId),
            'topic' => $this->getTopic($topicId),
            'errors' => $errors,
            'form_values' => $form_values,
        ]);
    }

    public function actionDelete($postId)
    {
        $form_values = [];
        $errors = [];

        $stmt = $this->pdo->prepare("SELECT topic_id FROM posts WHERE `id`=:post_id");
        if ($stmt->execute(['post_id' => $postId])) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $topicId = $data['topic_id'];
        }

	    $stmt = $this->pdo->prepare("DELETE FROM posts WHERE `id`=:post_id");
        if ($stmt->execute(['post_id' => $postId])) {
            $this->redirect('/posts/list/' . $topicId);
        } else {
	        $errors['delete'] = 'Nem sikerült a törlési művelet!';
	    }

	    echo $this->render('list', [
            'posts' => $this->getPosts($topicId),
            'topic' => $this->getTopic($topicId),
            'errors' => $errors,
            'form_values' => $form_values,
        ]);
    }

    private function getPosts($topicId)
    {
        $stmt = $this->pdo->prepare('SELECT posts.*, users.name as user_name FROM posts LEFT JOIN users ON users.id = posts.user_id WHERE topic_id = :topic_id ORDER BY created_at ASC');
        $stmt->execute(['topic_id' => $topicId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getTopic($topicId)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM topics WHERE id = :id');
        $stmt->execute(['id' => $topicId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
