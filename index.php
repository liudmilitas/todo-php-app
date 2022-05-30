<?php
// http://localhost/todo-php-app/

require_once __DIR__ . "/classes/Database.php";
require_once __DIR__ . "/classes/Todo.php";
require_once __DIR__ . "/classes/User.php";

session_start();

$db = new Database();

$is_logged_in = (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]);

if ($_SESSION["user"]) {
    $todos = $db->get_tasks($_SESSION["user"]->id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO APP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet" />
</head>

<body class="bg-primary">

    <?php
    $hash = password_hash("Linus", null);
    $correct = password_verify("Linus", $hash);
    $incorrect = password_verify("123123123", $hash);
    ?>

    <nav>
        <?php if (!$is_logged_in) : ?>
            <div class="d-block p-2">
                <a href="/todo-php-app/pages/register-user.php" class="d-inline text-white px-2">Register user</a>
                <a href="/todo-php-app/pages/login.php" class="d-inline text-white px-2">Login</a>
            </div>
        <?php else : ?>
            <div class="d-block p-2">
                <p class=" d-inline text-white px-2"><b>Logged in as</b> <?= $_SESSION["user"]->username ?></p>
                <form action="/todo-php-app/scripts/post-logout.php" method="post" class="d-inline">
                    <input type="submit" value="Logout" class="btn btn-warning">
                </form>
            </div>
        <?php endif; ?>
    </nav>
    <h1 class="mt-4 text-white text-center">Things To Do</h1>

    <div class="col-md-5 p-5 rounded bg-white mx-auto mt-5">
        <?php if ($is_logged_in) : ?>
            <div>
                <form action="/todo-php-app/scripts/create-task.php" method="POST" class="input-group-append">
                    <input type="text" name="title" placeholder="Enter task" required class="form-control mb-3">
                    <input type="date" name="date" placeholder="Enter date" required class="form-control mb-3">
                    <input type="submit" value="Create task" class="btn btn-primary">
                </form>
            </div>
            <br />
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Task</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $num = 1;
                    foreach ($todos as $todo) : ?>
                        <tr>
                            <th scope="row"><?= $num++ ?></th>
                            <td scope="row"><a href="/todo-php-app/pages/show-task.php?id=<?= $todo->id ?>"><strong><?= $todo->title ?></strong></a></td>
                            <td><?= $todo->date ?></td>
                            <td>
                                <a href="/todo-php-app/pages/show-task.php?id=<?= $todo->id ?>"><button class="btn btn-success">Edit task</button></a>
                                <form action="/todo-php-app/scripts/delete-task.php" method="POST" class=" d-inline-block">
                                    <input type="hidden" name="id" value="<?= $todo->id ?>">
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>
                            </td>

                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        <?php else : ?>
            <h4>No Task To Display - Please Log In</h4>
        <?php endif; ?>
    </div>
</body>

</html>