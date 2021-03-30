<?php

require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASS);

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlentities($story['title']) ?> - THE LEGENDS</title>
</head>
<body>
    <a href="index.php">Back to the legends</a>
    <h1><?= htmlentities($story['title']) ?> - A story by <?= htmlentities($story['author']) ?></h1>
    <p><?= htmlentities($story['content']) ?></p>
    <a href="edit.php?id=<?= $story['id'] ?>">Edit this story</a>
</body>
</html>
