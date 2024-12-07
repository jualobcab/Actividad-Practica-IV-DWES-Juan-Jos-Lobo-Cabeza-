<?php
    $pathFunciones = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "../includes/funciones.php");
    include_once $pathFunciones;

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nombreCat = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        insertCategoriaRedireccion($nombreCat,$descripcion);
    }
?>