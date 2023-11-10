<?php
function login($username, $password)
{
    // Recorrem l'array de usuaris i mirem si l'usuari i la contrasenya coincideixen
    foreach ($_SESSION['users'] as $usuari) {
        if ($usuari['nom'] == $username && $usuari['contra'] == $password) {
            return $usuari;
        }
    };
    return null;
}

function delete_admin($username)
{
    // Recorre l'array de usuaris i li canvia el valor de la variable "administrador" a fals
    foreach ($_SESSION['users'] as &$usuari) {
        if ($usuari['nom'] == $username) {
            $usuari['administrador'] = false;
            return $usuari;
        }
    };
    return null;
}


function add_admin($username)
{
    // Recorre l'array de usuaris i li canvia el valor de la variable "administrador" a true
    foreach ($_SESSION['users'] as &$usuari) {
        if ($usuari['nom'] == $username) {
            $usuari['administrador'] = true;
            return $usuari;
        }
    };
    return null;
}

function delete_user($username)
{
    // Recorre l'array de usuaris, comproba si els noms coincideixen i borra a l'usuari
    foreach ($_SESSION['users'] as $key => $usuari) {
        if ($usuari['nom'] == $username) {
            unset($_SESSION['users'][$key]);
            return $usuari;
        }
    };
    return null;
}

function is_task_correct($task)
{
    // Recorre l'array de tasques per veure que no hi hagin tasques repetides
    foreach ($_SESSION['user_logged']['tasques'] as $tasca) {
        if ($tasca['titol'] == $task['titol']) {
            $_SESSION['flash'] = "La tasca " . $task['titol'] . " ja existeix";
            return null;
        }
    };
    // Comprova que el titol no estigui buit i tingui entre 2 i 30 caràcters
    if (empty($task['titol']) || strlen($task['titol']) < 2 || strlen($task['titol']) > 30) {
        $_SESSION['flash'] = "El títol de la tasca no pot estar buit i ha de tenir entre 2 i 30 caràcters";
        return null;
    }
    // Comprova que la descripció no estigui buida i tingui com a màxim 1000 caràcters
    if (empty($task['descripcio']) || strlen($task['descripcio']) > 1000) {
        $_SESSION['flash'] = "La descripció de la tasca no pot estar buida i pot tenir com a màxim 1000 caràcters, tens " . strlen($task['descripcio']) . " caràcters";
        return null;
    }
    return $task;
}


function delete_tasca($task, $username)
{
    foreach ($_SESSION['users'] as &$usuari) {
        if ($usuari['nom'] == $username) {
            foreach ($usuari['tasques'] as $key => $tasca) {
                if ($tasca['titol'] == $task) {
                    unset($usuari['tasques'][$key]);
                    if ($usuari['nom'] == $_SESSION['user_logged']['nom']) {
                        unset($_SESSION['user_logged']['tasques'][$key]);
                    }
                    return $tasca;
                }
            };
        }
    };
}


function is_task_edit_correct($task, $originalName)
{
    // Comprova si la tasca original existeix
    $taskExists = false;
    foreach ($_SESSION['user_logged']['tasques'] as $tasca) {
        if ($tasca['titol'] === $originalName) {
            $taskExists = true;
            break;
        }
    }

    if (empty($task['titol']) || strlen($task['titol']) < 2 || strlen($task['titol']) > 30) {
        $_SESSION['flash'] = "El títol de la tasca no pot estar buit i ha de tenir entre 2 i 30 caràcters";
        return null;
    }
    if (empty($task['descripcio']) || strlen($task['descripcio']) > 1000) {
        $_SESSION['flash'] = "La descripció de la tasca no pot estar buida i pot tenir com a màxim 1000 caràcters, tens " . strlen($task['descripcio']) . " caràcters";
        return null;
    }

    // Comprova si el títol de la tasca és únic
    foreach ($_SESSION['user_logged']['tasques'] as $tasca) {
        if ($tasca['titol'] === $task['titol'] && $tasca['titol'] !== $originalName) {
            $_SESSION['flash'] = "Ja existeix una tasca amb aquest títol";
            return null;
        }
    }

    // Si tot és correcte, retorna la tasca a editar
    return $task;
}

function get_user_by_name($username)
{
    foreach ($_SESSION['users'] as $usuari) {
        if ($usuari['nom'] == $username) {
            return $usuari;
        }
    };
    return null;
}


function check_new_user($username, $email, $password)
{
    $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $correct = true;
    if (empty($username)) {
        $_SESSION['flash'] = "El nom d'usuari no pot estar buit";
        $correct = false;
    }
    if (empty($email)) {
        $_SESSION['flash'] = "L'email no pot estar buit";
        $correct = false;
    }
    if (empty($password)) {
        $_SESSION['flash'] = "La contrasenya no pot estar buida";
        $correct = false;
    }
    if (strlen($password) < 8) {
        $_SESSION['flash'] = "La contrasenya ha de tenir almenys 8 caràcters";
        $correct = false;
    }
    if (strlen($username) < 4 || strlen($username) > 20) {
        $_SESSION['flash'] = "El nom d'usuari ha de tenir entre 4 i 20 caràcters";
        $correct = false;
    }
    if (!preg_match($pattern, $email)) {
        $_SESSION['flash'] = "L'email no és vàlid, ex: exemple@exemple.cat";
        $correct = false;
    }
    if ($correct) {
        $correct = check_user_exists($username, $email);
    }
    return $correct;
}

function check_user_exists($username, $email)
{
    foreach ($_SESSION['users'] as $user) {
        if ($user['nom'] === $username) {
            $_SESSION['flash'] = "El nom d'usuari " . $username . " ja existeix";
            return false;
        } elseif ($user['email'] === $email) {
            $_SESSION['flash'] = "L'email " . $email . " ja ha sigut registrat";
            return false;
        }
    };
    return true;
}

function is_user_edit_correct($username, $email, $password)
{
    $correct = true;

    // Comprova si el nom d'usuari o correu electrònic ja estan en ús per un altre usuari
    $userLoggedIn = $_SESSION['user_logged'];

    foreach ($_SESSION['users'] as $user) {
        if ($user !== $userLoggedIn) {
            if ($user['nom'] === $username) {
                $_SESSION['flash'] = "Aquest nom d'usuari ja està en ús";
                $correct = false;
                break;
            }
            if ($user['email'] === $email) {
                $_SESSION['flash'] = "Aquest correu electrònic ja està en ús";
                $correct = false;
                break;
            }
        }
    }

    if (empty($username)) {
        $_SESSION['flash'] = "El nom d'usuari no pot estar buit";
        $correct = false;
    }
    if (empty($email)) {
        $_SESSION['flash'] = "L'email no pot estar buit";
        $correct = false;
    }
    if (empty($password)) {
        $_SESSION['flash'] = "La contrasenya no pot estar buida";
        $correct = false;
    }
    if (strlen($password) < 8) {
        $_SESSION['flash'] = "La contrasenya ha de tenir almenys 8 caràcters";
        $correct = false;
    }

    return $correct;
}

function get_user_by_email($email)
{
    foreach ($_SESSION['users'] as $user) {
        if ($user['email'] == $email) {
            return $user;
        }
    };
    return null;
}
