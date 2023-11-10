<?php
if (!isset($_SESSION)) session_start();
include_once('./func/func.php');
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
} else {
    header('Location: ./403.php');
    die();
}
if (!isset($_SESSION['tasca_actual'])) {
    if (isset($_GET)) {
        $_SESSION['tasca_actual'] = $_GET;
    }
}

if (isset($_POST['edit_sub'])) {
    $inputDeadline = $_POST['inputDeadline'];

    $date = new DateTime($inputDeadline);

    $formatted_date = $date->format('m/d/Y');

    $feta = isset($_POST['exampleCheck1']) ? true : false;

    $task = array(
        "titol" => $_POST['inputTitle'],
        "descripcio" => $_POST['inputDescription'],
        "feta" => $feta,
        "deadLine" => $formatted_date
    );

    $tasca_correcta = is_task_edit_correct($task, $_SESSION['tasca_actual']['tasca']);

    if (!is_null($tasca_correcta)) {
        // Recorre les tasques de l'usuari
        foreach ($_SESSION['user_logged']['tasques'] as &$tasca) {
            // Troba la tasca amb el mateix títol que volem editar
            if ($tasca['titol'] === $_SESSION['tasca_actual']['tasca']) {
                // Actualitza la tasca amb les noves dades
                $tasca = $task;
                break;  // Un cop actualitzada, podem sortir del bucle
            }
        }
        // Recorre els usuaris i copia l'usuari loggejat a l'user que toca de la sessió
        foreach ($_SESSION['users'] as &$usuari) {
            if ($usuari['nom'] == $_SESSION['user_logged']['nom']) {
                $usuari = $_SESSION['user_logged'];
                $_SESSION['flash'] = "Tasca editada correctament";
                unset($_SESSION['tasca_actual']);
                header('Location: ./main.php');
                break;
            }
        };
        die();
    }
}
?>

<!doctype html>
<html lang="ca">

<head>
    <title>2DoList - Nova Tasca</title>
    <?php
    include_once('templates/head.php');
    ?>
</head>

<body>
    <?php
    include_once('templates/nav.php');
    ?>
    <div class="tarjeta mt-5 col-5 mx-auto border px-3">
        <h1 class="mt-2">Edita la tasca</h1>
        <?php
        if (isset($_SESSION['flash'])) {
        ?>
            <small class="text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></small>
        <?php
            unset($_SESSION['flash']);
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <form>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="inputTitle" name="inputTitle" placeholder="Títol de la tasca" value="<?php echo isset($_POST['inputTitle']) ? $_POST['inputTitle'] : $_SESSION['tasca_actual']['tasca']; ?>" required>
                    <label for="inputTitle" class="form-label">Titol</label>
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" placeholder="Descripció" id="inputDescription" name="inputDescription" style="height: 100px" required><?php echo $_POST['inputDescription'] ?? $_SESSION['tasca_actual']['descripcio']; ?></textarea>
                    <label for="inputDescription">Descripció</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="date" class="form-control" id="inputDeadline" name="inputDeadline" placeholder="Deadline" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d', strtotime($_SESSION['tasca_actual']['deadLine'])) ?>">
                    <label for="inputDeadline" class="form-label">Deadline</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="exampleCheck1" class="form-check-input" id="exampleCheck1" <?php echo $_SESSION['tasca_actual']['feta'] === 'true' ? 'checked' : null; ?>>
                    <label class="form-check-label" for="exampleCheck1">Feta!</label>
                </div>
                <div class="text-end">
                    <button type="submit" name="edit_sub" class="btn btn-primary btn-lg mx-5">Edita Tasca!</button>
                    <a href="./main.php" class="btn btn-danger mx-3">Cancela</a>
                </div>
            </form>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>