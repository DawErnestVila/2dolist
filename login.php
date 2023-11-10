<?php
if (!isset($_SESSION)) session_start();
include_once('./func/func.php');
$_SESSION['show_now'] = "./register.php";


if (!isset($_SESSION['user_logged'])) {
    $_SESSION['user_logged'] = array();
}

$correct_pass = null;
$existeix = null;
if (isset($_POST['login_sub'])) {
    $result = login($_POST['username'], $_POST['password']);
    foreach ($_SESSION['users'] as $user) {
        if ($user['nom'] === $_POST['username']) {
            $existeix = true;
            break;
        } else {
            $existeix = false;
        }
    }

    if (!$existeix) {
        $_SESSION['flash'] = "El nom d'usuari " . $_POST['username'] . " no existeix";
    } else

    if (is_null($result)) {
        $correct_pass = false;
        $_SESSION['flash'] = "Les dades no són correctes";
    } else {
        $_SESSION['user_logged'] = $result;
        $correct_pass = true;
        header('Location: ./main.php');
        die();
    }
}
?>

<!doctype html>
<html lang="ca">

<head>
    <title>2DoList - Login</title>
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
        <h1 class="text-center my-5">Iniciar sessió</h1>
        <?php if (isset($_SESSION['flash'])) {
        ?>
            <small class="text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></small>
        <?php
            unset($_SESSION['flash']);
        } ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-4 form-floating">
                <input type="text" class="form-control" id="username" value="<?php echo $_POST['username'] ?? null; ?>" name="username" placeholder="Nom d'usuari" required>
                <label for="username" class="form-label">Nom d'usuari</label>
            </div>
            <div class="mb-4 form-floating">
                <input type="password" class="form-control" id="contra" value="<?php echo $_POST['password'] ?? null; ?>" name="password" placeholder="Contrasenya" required>
                <label for="password" class="form-label">Contrasenya</label>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-light mt-3 mb-3" name="login_sub">Iniciar sessió</button>
            </div>
            <div class="text-end mb-4">
                <small> No tens compte?
                    <a class="mt-5" href="./register.php">Registra't</a>
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