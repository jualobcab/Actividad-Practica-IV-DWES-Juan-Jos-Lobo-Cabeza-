<?php
    $pathFunciones = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "../includes/funciones.php");
    include_once $pathFunciones;

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $usuario = $_POST['user'];
        $contrasenya = $_POST['contrasenya'];

        loginRedireccion($usuario,$contrasenya);
    }
?>