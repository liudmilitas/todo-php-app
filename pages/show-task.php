<?php
require_once __DIR__ . "/../classes/Database.php";

session_start();

$db = new Database();

$is_logged_in = (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]);

if (!$is_logged_in) {
    echo "ACCESS ERROR! Log in first!";
    return;
}

$id = $_GET["id"];

$todo = $db->get_task_by_id($id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $todo->title ?></title>
    <link rel="stylesheet" href="/todo-php-app/assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet" />
</head>

<body class="bg-primary">
    <nav class="d-block p-2">
        <a href="/todo-php-app" class="d-inline text-white px-2">Back To Homepage</a>
        <?php if (!$is_logged_in) : ?>

            <a href="/todo-php-app/pages/register-user.php" class="d-inline text-white px-2">Register user</a>
            <a href="/todo-php-app/pages/login.php" class="d-inline text-white px-2">Login</a>

        <?php else : ?>
            <p class="d-inline text-white px-2"><b>Logged in as</b> <?= $_SESSION["user"]->username ?></p>
            <form action="/todo-php-app/scripts/post-logout.php" method="post" class="d-inline">
                <input type="submit" value="Logout" class="btn btn-warning ">
            </form>
        <?php endif; ?>
    </nav>


    <main class="col-md-5 p-5 rounded bg-white mx-auto mt-5">
        <?php if ($_SESSION["user"]->id === $todo->user_id) : ?>
            <h2>Task: <?= $todo->title ?></h2>
            <div>
                <form action="/todo-php-app/scripts/edit-task.php" method="POST" class="input-group-append">
                    <input type="text" name="title" placeholder="Edit task" value="<?= $todo->title ?>" class="form-control mb-3">
                    <input type="date" name="date" placeholder="Edit date" value="<?= $todo->date ?>" class="form-control mb-3">
                    <input type="hidden" name="id" value="<?= $todo->id ?>">
                    <input type="submit" value="Edit task" class="btn btn-primary">
                </form>

                <form action="/todo-php-app/scripts/delete-task.php" method="POST" class="mt-2">
                    <input type="hidden" name="id" value="<?= $todo->id ?>">
                    <input type="submit" value="Delete" class="btn btn-danger">
                </form>
            </div>

        <?php else : ?>
            <h4>Please login to see your tasks!</h4>
        <?php endif; ?>
    </main>
</body>

</html>