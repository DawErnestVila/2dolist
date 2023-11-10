<?php
if (!isset($_SESSION)) session_start();
$_SESSION['show_now'] = "./login.php";
include_once('./func/func.php');


$correct = true;
if (isset($_POST['register_sub'])) {
    $correct = check_new_user($_POST['username'], $_POST['email'], $_POST['password']);

    if ($correct) {
        $user = array(
            "nom" => $_POST['username'],
            "email" => $_POST['email'],
            "contra" => $_POST['password'],
            "administrador" => false,
            "createdAt" => date('d/m/Y - H:i:s'),
            "tasques" => array()
        );
        $_SESSION['users'][] = $user;
        header('Location: ./login.php');
        die();
    }
}


?>

<!doctype html>
<html lang="ca">

<head>
    <title>2DoList - Register</title>
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
        <h1 class="text-center my-5">Registra't</h1>
        <?php if (isset($_SESSION['flash'])) {
        ?>
            <small class="text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></small>
        <?php
            unset($_SESSION['flash']);
            unset($_SESSION['err_passwd']);
        } ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-4 form-floating">
                <input type="text" value="<?php echo $_POST['username'] ?? null; ?>" class="form-control" id="username" name="username" placeholder="Nom d'usuari" required>
                <label for="username">Nom d'usuari</label>
            </div>
            <div class="mb-4 form-floating">
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $_POST['email'] ?? null; ?>" placeholder="Email" required>
                <label for="email" class="form-label">Email de l'usuari</label>
            </div>
            <div class="mb-4 form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contrasenya" value="<?php echo $_POST['password'] ?? null; ?>" required>
                <label for="password" class="form-label">Contrasenya</label>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-light mt-3 mb-3" name="register_sub">Registra't</button>
            </div>
            <div class="text-end mb-4">
                <small>Ja tens compte?
                    <a class="mt-5" href="./login.php">Logeja't</a>
                </small>
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