<?php
if (!isset($_SESSION)) session_start();
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
} else {
    header('Location: ./403.php');
    die();
}
unset($_SESSION['user_logged']);
header('Location: ./login.php');
