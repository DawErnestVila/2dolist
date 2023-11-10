<?php
if (!isset($_SESSION)) session_start();
include_once('./func/func.php');
if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
} else {
    header('Location: ./403.php');
    die();
}

$correct = true;
if (isset($_POST['edit_sub'])) {
    $correct = is_user_edit_correct($_POST['username'], $_POST['email'], $_POST['password']);

    if ($correct) {
        foreach ($_SESSION['users'] as $key => $user) {
            if ($user['email'] === $_SESSION['user_logged']['email']) {
                $_SESSION['users'][$key]['nom'] = $_POST['username'];
                $_SESSION['users'][$key]['email'] = $_POST['email'];
                $_SESSION['users'][$key]['contra'] = $_POST['password'];
            }
        }
        $_SESSION['user_logged']['nom'] = $_POST['username'];
        $_SESSION['user_logged']['email'] = $_POST['email'];
        $_SESSION['user_logged']['contra'] = $_POST['password'];
        $_SESSION['flash'] = "Usuari editat correctament";
        header('Location: ./main.php');
        die();
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <title>2DoList - Editar Usuari</title>
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
    <main class="tarjeta mt-5 col-5 mx-auto border px-3">
        <?php
        if ($_SESSION['user_logged']['nom'] == "admin") {
        ?>
            <h1 class="text-center my-5">No pots editar aquest usuari</h1>
        <?php
        } else {
        ?>
            <h1 class="text-center my-5">Edita el teu usuari</h1>
        <?php } ?>
        <?php if (isset($_SESSION['flash'])) {
        ?>
            <small class="text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></small>
        <?php
            unset($_SESSION['flash']);
            unset($_SESSION['err_passwd']);
        } ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-4 form-floating">
                <input type="text" value="<?php echo $_POST['username'] ?? $_SESSION['user_logged']['nom']; ?>" class="form-control" id="username" name="username" placeholder="Nom d'usuari" <?php echo ($_SESSION['user_logged']['nom'] == "admin") ? "disabled" : null  ?> required>
                <label for="username">Nom d'usuari</label>
            </div>
            <div class="mb-4 form-floating">
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $_POST['email'] ?? $_SESSION['user_logged']['email']; ?>" placeholder="Email" <?php echo ($_SESSION['user_logged']['nom'] == "admin") ? "disabled" : null  ?> required>
                <label for="email" class="form-label">Email de l'usuari</label>
            </div>
            <div class="mb-4 form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contrasenya" value="<?php echo $_POST['password'] ?? $_SESSION['user_logged']['contra']; ?>" <?php echo ($_SESSION['user_logged']['nom'] == "admin") ? "disabled" : null  ?> required>
                <label for="password" class="form-label">Contrasenya</label>
            </div>
            <div class="text-center">
                <?php
                if ($_SESSION['user_logged']['nom'] == "admin") {
                ?>
                    <a href="./main.php" class="btn btn-primary">Torna Enrere</a>
                <?php
                } else {
                ?>
                    <button type="submit" class="btn btn-primary mt-3 mb-3" name="edit_sub">Edita</button>
                <?php } ?>
            </div>
        </form>
        <hr>
    </main>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>