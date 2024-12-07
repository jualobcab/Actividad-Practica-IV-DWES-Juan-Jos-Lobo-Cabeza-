<?php
    $pathFunciones = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "../includes/funciones.php");
    include_once $pathFunciones;

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = (float) $_POST['precio'];
        $nombreCategoria = $_POST['selectCategoria'];
        $magico = false;
        if (isset($_POST['magico']) && $_POST['magico']=="magico"){
            $magico = true;
        }

        modificarProductoRedireccion($id,$nombre,$descripcion,$precio,$nombreCategoria,$magico);
    }
?>