<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Login.css">
</head>

<body>
    <form action="index.php" method="post">
        <h2>LOGIN</h2>
        <?php if(isset($_GET['error'])){ ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
        <?php } ?>
        <label for="">Username:</label>
        <input type="text" name="username" placeholder="Username"><br>
        <label for="">Password:</label>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>