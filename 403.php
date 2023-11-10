<?php
if (!isset($_SESSION)) session_start();
?>

<!doctype html>
<html lang="ca">

<head>
    <title>2DoList - 403</title>
    <?php
    include_once('templates/head.php');
    ?>
</head>

<body>
    <?php
    include_once('templates/nav.php');
    ?>
    <header>
        <h1>Error, no tens permís per veure aquesta pàgina</h1>
    </header>
    <main>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>