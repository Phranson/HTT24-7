<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>HappyTenderTouchInc | Login</title>
</head>

<body>
    <div class="fromContainer">
        <img src="./assets/img/Logo512.webp" alt="Logo">
        <form id="loginForm" method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="userName">Username</label>
            <input type="text" id="userName" name="userName" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <input type="checkbox" id="showPw" value="true">
            <label for="showPw">Show password?</label>
            <input type="submit" id="submit" value="Login">
        </form>
    </div>
    <script src="assets/js/login.js"></script>
    <script src="assets/js/pushMessage.js"></script>

    <?php
    session_start();
    if (isset($_SESSION["pushMessage"])) {
        echo '<script>pushMessage(' . $_SESSION["pushMessage"] . ')</script>';
        unset($_SESSION["pushMessage"]);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["userName"];
        $password = $_POST["password"];
        require("./core/config.php");
        require("./models/Auth.php");
        require("./models/Person.php");
        $auth = new Auth(null, null, null, null, null, null, null, null);
        $result = $auth->login($username, $password);
        if ($result == 0) {
            $_SESSION["pushMessage"] = '"Welcome back, ' . $_SESSION["userFName"] . '! We\'re thrilled to see you again. Let\'s dive into your dashboard and get started with your tasks.", "success"';
            header("Location: index.php");
            exit();
        } elseif ($result == 1) {
            $_SESSION["pushMessage"] = '"Oops! It looks like the <strong>username</strong> you entered doesn\'t match our records. Please double-check your username and try again.", "error"';
        } elseif ($result == 2) {
            $_SESSION["pushMessage"] = '"It seems the <strong>password</strong> you entered is incorrect. Please try again, making sure you\'re entering the correct password. Remember, passwords are case-sensitive.", "error"';
        }
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']));
        exit();
    }
    //echo password_hash("1234", PASSWORD_BCRYPT);

    ?>
</body>

</html>