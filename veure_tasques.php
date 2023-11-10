<?php
if (!isset($_SESSION)) session_start();
include_once('./func/func.php');
$_SESSION['hide_new_task'] = true;
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
    if (!$_SESSION['user_logged']['administrador']) {
        header('Location: ./403.php');
        die();
    }
} else {
    header('Location: ./403.php');
    die();
}

$user = get_user_by_name($_GET['nom']);

?>

<!doctype html>
<html lang="ca">

<head>
    <title>2DoList - Tasques</title>
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
    <a href="./usuaris.php" class="btn btn-danger m-3 btn-lg"><i class="bi bi-caret-left-fill"></i>Torna enrere</a>
    <h1 class="m-3 my-5">🕵🏼‍♂️Veient tasques de <?php echo $user['nom'] ?>:</h1>
    <?php
    if ($user['tasques'] === array()) {
    ?>

        <div class="col-11 mx-auto my-3 bg-light p-2">
            <?php if (isset($_SESSION['flash'])) {

            ?>

                <p class="text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></p>
            <?php
                unset($_SESSION['flash']);
            } ?>
            <h2 class="m-3">No té cap tasca</h2>
        </div>
    <?php } else { ?>
        <main class="border col-11 mx-auto mb-3">
            <?php if (isset($_SESSION['flash'])) {
            ?>

                <p class="text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></p>
            <?php
                unset($_SESSION['flash']);
            } ?>
            <?php
            foreach ($user['tasques'] as $tasca) {
            ?>
                <div class="col-11 mx-auto my-3 bg-light p-2 <?php echo $tasca['feta'] ? 'text-secondary text-decoration-line-through' : 'text-black' ?>">
                    <h2 class="m-3"><?php echo $tasca['titol'] ?></h2>
                    <p class="m-3"><?php echo $tasca['descripcio'] ?></p>
                    <?php
                    if ($tasca['feta']) {
                        echo "<p class='m-3'><b>Deadline: " . $tasca['deadLine'] . "</b></p>";
                    } else {
                        $data_actual = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                        $data_actual_formatada = $data_actual->format('d/m/Y');

                        $tasca_deadline = DateTime::createFromFormat('m/d/Y', $tasca['deadLine']);

                        if ($tasca_deadline > $data_actual) {
                            echo "<p class='m-3'><b>Deadline: " . $tasca['deadLine'] . "</b></p>";
                        } elseif ($tasca_deadline->format('d/m/Y') === $data_actual_formatada) {
                            echo "<p class='m-3 text-warning'><b>Deadline: " . $tasca['deadLine'] . "</b></p>";
                        } else {
                            echo "<p class='m-3 text-danger'><b>Deadline: " . $tasca['deadLine'] . "</b></p>";
                        }
                    }
                    ?>
                    <div class="text-end m-3">
                        <a href="./elimina_tasca.php?tasca=<?php echo $tasca['titol'] ?>&name=<?php echo $user['nom'] ?>" class="btn btn-danger">Esborrar</a>
                    </div>
                </div>
            <?php } ?>
        </main>
    <?php } ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>