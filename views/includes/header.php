<?php
session_start();
if (!isset($_SESSION['userRole'])) {
    header("Location: login.php");
    exit();
}


$role = "";


switch ($_SESSION['userRole']) {
    case '1':
        $role = 'staff';
        break;
    case '2':
        $role = 'visitor';
        break;
    case '3':
        $role = 'client';
        break;
    default:
        $role = 'unauthorized';
        break;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $headerTitle ?> | Happy Tender Touch Inc.</title>
    <link rel="stylesheet" href="assets/css/globalColors.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container">
        <header>
            <img height="100px" width="100px" src="assets/img/Logo512.webp">
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    <li>logged in as <strong><?php echo $_SESSION['userFName']; ?></strong> (<strong><?php echo $role; ?></strong>)
                    <li>
                </ul>
            </nav>
        </header>