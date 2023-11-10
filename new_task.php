<?php
if (!isset($_SESSION)) session_start();
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
} else {
    header('Location: ./403.php');
    die();
}
include_once('./func/func.php');


if (isset($_POST['task_sub'])) {
    $inputDeadline = $_POST['inputDeadline'];

    $date = new DateTime($inputDeadline);

    $formatted_date = $date->format('m/d/Y');

    $task = array(
        "titol" => $_POST['inputTitle'],
        "descripcio" => $_POST['inputDescription'],
        "feta" => false,
        "deadLine" => $formatted_date
    );
    $tasca_correcta = is_task_correct($task);

    if (!is_null($tasca_correcta)) {
        $_SESSION['user_logged']['tasques'][] = $task;
        foreach ($_SESSION['users'] as $key => $user) {
            if ($user['email'] === $_SESSION['user_logged']['email']) {
                $_SESSION['users'][$key]['tasques'][] = $task;
            }
        }

        $_SESSION['flash'] = "Tasca creada correctament";
        header('Location: ./main.php');
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
        <?php
        if (isset($_SESSION['flash'])) {
        ?>
            <div class="text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></div>
        <?php
        } else {
            unset($_SESSION['flash']);
        }
        ?>

        <h1 class="mt-2">Nova Tasca</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" id="inputTitle" name="inputTitle" value="<?php echo $_POST['inputTitle'] ?? null; ?>" placeholder="Títol de la tasca" required>
                <label for="inputTitle" class="form-label">Titol</label>
            </div>
            <div class="mb-3 form-floating">
                <textarea class="form-control" placeholder="Descripció" id="inputDescription" name="inputDescription" style="height: 100px" required><?php echo $_POST['inputDescription'] ?? null; ?></textarea>
                <label for="inputDescription">Descripció</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="date" class="form-control" id="inputDeadline" name="inputDeadline" placeholder="Deadline" min="<?php echo date('Y-m-d'); ?>" value="<?php echo ((isset($task)) ? date('Y-m-d', strtotime($task['deadLine'])) : date('Y-m-d')); ?>">
                <label for="inputDeadline" class="form-label">Deadline</label>
            </div>
            <button type="submit" name="task_sub" class="btn btn-primary">Afegeix Tasca!</button>
        </form>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>