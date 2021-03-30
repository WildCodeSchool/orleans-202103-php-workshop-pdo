<?php

require_once 'connec.php';

define('TITLE_MAX_LENGTH', 255);
define('AUTHOR_MAX_LENGTH', 100);

$pdo = new PDO(DSN, USER, PASS);
$errors = [];

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $query = 'SELECT * FROM story WHERE id=:id';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $story = $statement->fetch();
    if (false === $story) {
        header('HTTP/1.1 404 Not Found');
        exit('404 - The story you are looking for does not exist');
    }
} else {
    header('HTTP/1.1 404 Not Found');
    exit('404 - The story you are looking for does not exist');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $story = array_map('trim', $_POST);
    $story['id'] = $_GET['id'];

    if (empty($story['title'])) {
        $errors[] = 'Your story must have a title';
    }

    if (empty($story['author'])) {
        $errors[] = 'Your story must have an author';
    }

    if (empty($story['content'])) {
        $errors[] = 'Your story must have some content';
    }

    if (strlen($story['title']) > TITLE_MAX_LENGTH) {
        $errors[] = 'Your title must not exceed ' . TITLE_MAX_LENGTH . ' characters';
    }

    if (strlen($story['author']) > AUTHOR_MAX_LENGTH) {
        $errors[] = 'Your author\'s name must not exceed ' . AUTHOR_MAX_LENGTH . ' characters';
    }

    if (empty($errors)) {
        $query = 'UPDATE story SET title=:title, author=:author, content=:content WHERE id=:id';

        $statement = $pdo->prepare($query);
        $statement->bindValue(':title', $story['title'], PDO::PARAM_STR);
        $statement->bindValue(':author', $story['author'], PDO::PARAM_STR);
        $statement->bindValue(':content', $story['content'], PDO::PARAM_STR);
        $statement->bindValue(':id', $story['id'], PDO::PARAM_INT);

        $statement->execute();

        header('Location: show.php?id=' . $story['id']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE - THE LEGENDS</title>
</head>
<body>
    <h1>UPDATE THE LEGENDS</h1>
    <a href="show.php?id=<?= $story['id'] ?>">Cancel</a>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
    <form action="" method="POST">
        <label for="title">Title : </label>
        <input type="text" name="title" id="title" maxlength="255" value="<?= $story['title'] ?? '' ?>" required>
        <label for="author">Author : </label>
        <input type="text" name="author" id="author" maxlength="100" value="<?= $story['author'] ?? '' ?>" required>
        <label for="content">Content : </label>
        <textarea name="content" id="content" required><?= $story['content'] ?? '' ?></textarea>
        <button>Update</button>
    </form>
    <a href="delete.php?id=<?= $story['id'] ?>">Delete this story</a>
</body>
</html>
