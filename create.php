<?php

require_once 'connec.php';

define('TITLE_MAX_LENGTH', 255);
define('AUTHOR_MAX_LENGTH', 100);

$pdo = new PDO(DSN, USER, PASS);
$errors = [];

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $data = array_map('trim', $_POST);

    if (empty($data['title'])) {
        $errors[] = 'Your story must have a title';
    }

    if (empty($data['author'])) {
        $errors[] = 'Your story must have an author';
    }

    if (empty($data['content'])) {
        $errors[] = 'Your story must have some content';
    }

    if (strlen($data['title']) > TITLE_MAX_LENGTH) {
        $errors[] = 'Your title must not exceed ' . TITLE_MAX_LENGTH . ' characters';
    }

    if (strlen($data['author']) > AUTHOR_MAX_LENGTH) {
        $errors[] = 'Your author\'s name must not exceed ' . AUTHOR_MAX_LENGTH . ' characters';
    }

    if (empty($errors)) {
        $query = 'INSERT INTO story (title, author, content) VALUES (:title, :author, :content)';

        $statement = $pdo->prepare($query);
        $statement->bindValue(':title', $data['title'], PDO::PARAM_STR);
        $statement->bindValue(':author', $data['author'], PDO::PARAM_STR);
        $statement->bindValue(':content', $data['content'], PDO::PARAM_STR);

        $statement->execute();

        header('Location: index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREATE - THE LEGENDS</title>
</head>
<body>
    <h1>CREATE THE LEGENDS</h1>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
    <form action="" method="POST">
        <label for="title">Title : </label>
        <input type="text" name="title" id="title" maxlength="255" value="<?= $data['title'] ?? '' ?>" required>
        <label for="author">Author : </label>
        <input type="text" name="author" id="author" maxlength="100" value="<?= $data['author'] ?? '' ?>" required>
        <label for="content">Content : </label>
        <textarea name="content" id="content" required><?= $data['content'] ?? '' ?></textarea>
        <button>Save</button>
    </form>
</body>
</html>
