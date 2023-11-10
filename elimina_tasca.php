<?php
if (!isset($_SESSION)) session_start();
include_once('./func/func.php');
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
} else {
    header('Location: ./403.php');
    die();
}

$tasca = delete_tasca($_GET['tasca'], $_GET['name']);

// echo  $_GET['name'];
// echo $_GET['tasca'];
// echo var_dump($tasca);

if (!is_null($tasca)) {
    $_SESSION['flash'] = "La tasca " . $tasca['titol'] . " ha estat eliminada";
} else {
    $_SESSION['flash'] = "Error al eliminar la tasca " . $_GET['tasca'];
}

// Recorre els usuaris i copia l'usuari loggejat a l'user que toca de la sessió
// foreach ($_SESSION['users'] as &$usuari) {
//     if ($usuari['nom'] == $_SESSION['user_logged']['nom']) {
//         $usuari = $_SESSION['user_logged'];
//         break;
//     }
// };

header('Location: ' . $_SERVER['HTTP_REFERER']);
