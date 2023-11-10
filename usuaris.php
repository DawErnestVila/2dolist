<?php
if (!isset($_SESSION)) session_start();
$_SESSION['hide_new_task'] = false;

if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
    if (!$_SESSION['user_logged']['administrador']) {
        header('Location: ./403.php');
        die();
    }
} else {
    header('Location: ./403.php');
    die();
}

?>
<!doctype html>
<html lang="ca">

<head>
    <title>2DoList - Administrar Usuaris</title>
    <?php
    include_once('templates/head.php');

    ?>
</head>

<body>
    <?php
    include_once('templates/nav.php');
    ?>

    <h1 class="m-5">Usuaris</h1>
    <div class="col-6 mx-5">
        <table class="table table-striped table-bordered bg-light">
            <thead class="thead-dark">
                <tr>
                    <th>Admin</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Contrassenya</th>
                    <th>Tasques</th>
                    <th>Creat</th>
                    <th>Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['users'] as $user) {
                    if ($user['nom'] === 'admin' && $_SESSION['user_logged']['nom'] !== 'admin') {
                    } else { ?>
                        <tr>
                            <td class="col-1 <?php echo $user['administrador'] ? 'text-success' : 'text-danger'; ?>" style="font-size: 1.2em;"><?php echo $user['administrador'] ? 'Sí' : 'No'; ?></td>
                            <td class="col-2"><?php echo $user['nom']; ?></td>
                            <td class="col-2"><?php echo $user['email']; ?></td>
                            <td class="col-2"><?php echo $user['contra']; ?></td>
                            <td class="col-1"><?php echo count($user['tasques']); ?></td>
                            <td class="col-1"><?php echo $user['createdAt']; ?></td>
                            <td class="text-center col-3">
                                <?php if (!$user['administrador']) { ?>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a name="user_id" href="./afegir_admin.php?user=<?php echo $user['nom']; ?>" class="btn btn-success">Fer admin</a>
                                        <a name="user_id" href="./elimina_user.php?user=<?php echo $user['nom']; ?>" class="btn btn-danger mx-2">Esborrar</a>
                                    </div>
                                <?php } elseif ($_SESSION['user_logged']['nom'] !== $user['nom'] && $user['nom'] !== 'admin') { ?>
                                    <a name="user_id" href="./treure_admin.php?user=<?php echo $user['nom']; ?>" class="btn btn-warning">Treure admin</a>
                                <?php }
                                if ($user['nom'] !== 'admin' && $_SESSION['user_logged']['nom'] !== $user['nom']) {
                                ?>
                                    <a href="./veure_tasques.php?nom=<?php echo $user['nom'] ?>" class="btn btn-primary mt-2">Veure tasques</a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
        <?php
        if (isset($_SESSION['flash'])) {
        ?>
            <small class=" text-danger bg-light p-1"><?php echo $_SESSION['flash'] ?></small>
        <?php
            unset($_SESSION['flash']);
        }
        ?>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>