<?php
if (!isset($_SESSION)) session_start();
$_SESSION['show_now'] = "./login.php";

unset($_SESSION['user_logged']);
$_SESSION['users'] = array();
$user = array(
    "nom" => "admin",
    "email" => "admin@admin.com",
    "contra" => "admin",
    "administrador" => true,
    "createdAt" => (new DateTime('now', new DateTimeZone('Europe/Madrid')))->format('d/m/Y - H:i:s'),
    "tasques" => array()
);
$tasca = array(
    "titol" => "Tasca 1 Admin",
    "descripcio" => "Descripció de la tasca 1 Admin",
    "feta" => false,
    "deadLine" => (new DateTime('now', new DateTimeZone('Europe/Madrid')))->modify('+5 days')->format('d/m/Y')
);
$user['tasques'][] = $tasca;
$_SESSION['users'][] = $user;
$user = array(
    "nom" => "Ernest",
    "email" => "ernest@ernest.com",
    "contra" => "123",
    "administrador" => true,
    "createdAt" => (new DateTime('now', new DateTimeZone('Europe/Madrid')))->format('d/m/Y - H:i:s'),
    "tasques" => array()
);
$tasca = array(
    "titol" => "Tasca 1 Ernest",
    "descripcio" => "Descripció de la tasca 1 Ernest",
    "feta" => true,
    "deadLine" => (new DateTime('now', new DateTimeZone('Europe/Madrid')))->modify('+5 days')->format('d/m/Y')

);
$user['tasques'][] = $tasca;
$tasca = array(
    "titol" => "Tasca 2 Ernest",
    "descripcio" => "Descripció de la tasca 2 Ernest",
    "feta" => false,
    "deadLine" => (new DateTime('now', new DateTimeZone('Europe/Madrid')))->modify('-1 day')->format('d/m/Y')
);
$user['tasques'][] = $tasca;
$_SESSION['users'][] = $user;
$user = array(
    "nom" => "Joan",
    "email" => "joan@joan.com",
    "contra" => "123",
    "administrador" => false,
    "createdAt" => (new DateTime('now', new DateTimeZone('Europe/Madrid')))->format('d/m/Y - H:i:s'),
    "tasques" => array()
);
$_SESSION['users'][] = $user;
?>
<!doctype html>
<html lang="ca">

<head>
    <title>2DoList</title>
    <?php
    include_once('templates/head.php');

    ?>
</head>

<body>
    <header>
        <?php
        include_once('templates/nav.php');
        ?>
    </header>
    <div class="tarjeta text-center pt-5 px-3">
        <b>
            <h1 class="my-5 display-1">2DoList</h1>
        </b>
        <a href="./register.php" class="btn btn-light my-5">
            <small class="display-6">Registra't</small>
        </a>
        <div class="text-end"><small>&copy;Ernest Vilà</small></div>
        <hr>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>