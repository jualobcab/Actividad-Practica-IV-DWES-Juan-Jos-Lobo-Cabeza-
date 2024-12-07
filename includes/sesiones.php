<?php
    include_once "bd.php";
    include_once "funciones.php";

    function crearSesion($usuario, $rol){
        session_start();
        $_SESSION['usuario']=$usuario;
        $_SESSION['rol']=$rol;
    }
?>