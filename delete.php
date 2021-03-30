<?php

// The only reason I redirect to a new page and don't put the delete form in the update page is because I wanted to add a confirmation message before deleting the story and not bother with js alerts. This is not ideal though, since it makes us repeat a block of code.

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

if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    $query = 'DELETE FROM story WHERE id=:id';
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DELETE - THE LEGENDS</title>
</head>
<body>
    <h1>DELETE THE LEGENDS</h1>
    <p>Are you sure you want to delete "<?= $story['title'] ?>"?</p>
    <a href="edit.php?id=<?= $story['id'] ?>">Cancel</a>
    <form action="" method="POST">
        <input type="hidden" name="id" id="id" value="<?= $story['id'] ?>">
        <button>Delete</button>
    </form>
</body>
</html>
