<?php
if (!isset($_SESSION)) session_start();
include_once('./func/func.php');
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
    if (!$_SESSION['user_logged']['administrador']) {
        header('Location: ./403.php');
        die();
    }
} else {
    header('Location: ./403.php');
    die();
}

$user = delete_user($_GET['user']);

if (!is_null($user)) {
    $_SESSION['flash'] = "L'usuari " . $user['nom'] . " ha estat eliminat";
} else {
    $_SESSION['flash'] = "Error al eliminar l'usuari " . $_GET['user'];
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
