<?php
    $pathFunciones = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "includes/funciones.php");
    include_once $pathFunciones;

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id_producto'];

        redireccionBorrarProducto($id);
    }
?>