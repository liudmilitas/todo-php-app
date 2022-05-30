<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register user</title>
    <link rel="stylesheet" href="/todo-php-app/assets/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet" />
</head>

<body class="bg-primary">
    <nav class="d-block p-2">
        <a href="/todo-php-app" class="d-inline text-white px-2">Back To Homepage</a>
    </nav>
    <main class="col-md-5 p-5 rounded bg-white mx-auto mt-5 center-block">

        <h1 class="text-center">Register user</h1>
        <form action="/todo-php-app/scripts/post-register-user.php" method="post" class="input-group-append">
            <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
            <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
            <input type="submit" value="Register" class="btn btn-primary">
        </form>
    </main>

</body>

</html>