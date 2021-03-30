<?php

require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASS);

$query = 'SELECT * FROM story';
$statement = $pdo->query($query);
$stories = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE LEGENDS</title>
</head>
<body>
    <h1>THE LEGENDS</h1>
    <?php if (empty($stories)): ?>
        <p>No story found... Time for you to write the legends!</p>
    <?php endif; ?>
    <a href="create.php">Add a story</a>
    <ol>
        <?php foreach ($stories as $story): ?>
            <li><a href="show.php?id=<?= $story['id'] ?>"><?= htmlentities($story['title']) ?></a></li>
        <?php endforeach; ?>
    </ol>
</body>
</html>
