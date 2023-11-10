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

$user = add_admin($_GET['user']);


if (!is_null($user)) {
    $_SESSION['flash'] = "S'han afegit permisos d'administrador a l'usuari " . $user['nom'] . ".";
} else {
    $_SESSION['flash'] = "No s'han pogut afegir els permisos d'administrador de l'usuari " . $user['nom'] . ".";
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
