<?php

require_once __DIR__ . "./../classes/Database.php";
require_once __DIR__ . "./../classes/Todo.php";

session_start();
$success = false;

if (isset($_POST["title"]) && isset($_POST["date"])) {
    $todo_task = $_POST["title"];
    $todo_date = $_POST["date"];

    $todo = new Todo($todo_task, $todo_date, $_SESSION["user"]->id);

    $db = new Database();

    $success = $db->save_task($todo);
} else {
    echo "Invalid input";
}

if ($success) {
    header("Location: http://localhost/todo-php-app/");
    die();
} else {
    echo "Error saving task to database";
}
