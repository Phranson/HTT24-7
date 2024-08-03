<?php
session_start();
// if (!isset($_SESSION['userId'])) {
//     header("Location: login.php");
//     exit();
// }

require('core/init.php');


$app = new App();
