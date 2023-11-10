<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    body {
        background-color: #bdb3b2;
    }

    .tarjeta {
        background-color: #ced2d9;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 70%;
        height: 80%;
    }

    .tarjeta-reves {
        z-index: -2;
        background-color: #ced2d9;
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 70%;
        height: 80%;
    }
</style>
<nav class="d-flex justify-content-between p-3 bg-dark text-white">
    <div class="left d-flex align-items-center">
        <i class="bi bi-card-checklist"> - 2DoList</i>
        <div class="d-flex align-items-center">
            <?php
            if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
                if (!$_SESSION['hide_new_task']) {
                    echo '<a class="text-decoration-none mx-3 btn btn-info" href="./main.php">Home</a>';
                }
            } else {
                echo '<a class="text-decoration-none mx-3 btn btn-info" href="./index.php">Home</a>';
            }
            ?>
        </div>
    </div>
    <div class="right d-flex">
        <?php
        if (isset($_SESSION['user_logged']) && !empty($_SESSION['user_logged'])) {
            if (!$_SESSION['hide_new_task']) { ?>
                <a class="btn btn-success mx-4" href="./new_task.php">+ Tasca</a>
            <?php
            }
            ?>

            <div class="d-flex align-items-center mx-1">Benvingut, <a class="text-white font-weight-bold text-decoration-none mx-2 dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['user_logged']['nom'] ?></a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php
                    if ($_SESSION['user_logged']['nom'] != "admin") {
                    ?>
                        <li><a class="dropdown-item" href="./editar_usuari.php">Editar Usuari</a></li>
                    <?php
                    }
                    if ($_SESSION['user_logged']['administrador']) {
                        echo '<li><a class="dropdown-item" href="./usuaris.php">Administrar Usuaris</a></li>';
                    };
                    ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="./logout.php">LogOut</a></li>
                </ul>
            </div>
        <?php
        } else {
        ?>
            <div class="d-flex align-items-center">
                <a class="text-decoration-none mx-2 btn btn-light" href="<?php echo $_SESSION['show_now'] ?>"><?php echo $_SESSION['show_now'] == "./login.php" ? "Login" : "Register" ?></a>
            </div>
        <?php
        }
        ?>
    </div>
</nav>