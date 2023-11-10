<?php
if (!isset($_SESSION)) session_start();
include_once('func/func.php');
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
    if (!$_SESSION['user_logged']['administrador']) {
        header('Location: ./403.php');
        die();
    }
} else {
    header('Location: ./403.php');
    die();
}

$user = delete_admin($_GET['user']);

if (!is_null($user)) {
    $_SESSION['flash'] = "S'han tret els permisos d'administrador de l'usuari " . $user['nom'] . ".";
} else {
    $_SESSION['flash'] = "No s'ha pogut treure els permisos d'administrador de l'usuari " . $user['nom'] . ".";
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
