<?php

require_once __DIR__ . "/../classes/Database.php";

if (isset($_POST["title"]) && isset($_POST["date"]) && $_POST["id"]) {

    $db = new Database();

    $todo = new Todo($_POST["title"], $_POST["date"], $_SESSION["user"]->id, $_POST["id"]);

    $success = $db->edit_task($todo);
} else {
    echo "Invalid input";
}

if ($success) {
    header("Location: http://localhost/todo-php-app/pages/show-task.php?id=" . $_POST["id"]);
    die();
} else {
    echo "Edit Task Error";
}
