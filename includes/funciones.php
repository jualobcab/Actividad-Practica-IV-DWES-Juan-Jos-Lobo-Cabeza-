<?php
    include_once "sesiones.php";
    include_once "bd.php";

    function loginRedireccion($user,$password){
        $res = comprobacionUsuario($user,$password);

        if ($res){
            session_start();
            $_SESSION['mensaje'] = "Bienvenido a la tienda, ".($_SESSION['usuario']);

            header('Location: ../index.php');
        }
        else {
            session_start();
            $_SESSION['mensaje'] = "Error: usuario o contraseña incorrectos";

            header('Location: ../login.php');
        }
    }

    // CREACION DE TABLAS
    function crearTablaProductos(){
        $productos = productosToList();

        forEach($productos as $p){
            echo "<tr>
                    <th scope='row'>".$p[1]."</th>
                    <td>".$p[2]."</td>
                    <td>".$p[3]."</td>
                    <td>".$p[4]."</td>
                    <td>".$p[5]."</td>
                    <td>".$p[6]."</td>";
            if ($_SESSION['rol']=="admin"){
                echo "<td style='display:flex; flex_direction:row;gap:5px'>
                        <form method='post' action='productos_actualizar.php'>
                            <input type='hidden' id='id_producto' name='id_producto' value=".$p[0].">
                            <input type='hidden' id='nombre' name='nombre' value=".$p[1].">
                            <input type='hidden' id='descripcion' name='descripcion' value=".$p[2].">
                            <input type='hidden' id='precio' name='precio' value=".$p[3].">
                            <input type='hidden' id='magico' name='magico' value=".$p[4].">
                            <input type='hidden' id='fecha' name='fecha' value=".$p[5].">
                            <input type='hidden' id='categoria' name='categoria' value=".$p[6].">
                            <button type='submit' class='btn btn-primary'>Modificar</button>
                        </form>
                        <form method='post' action='productos_borrar.php'>
                            <input type='hidden' id='id_producto' name='id_producto' value=".$p[0].">
                            <button type='submit' class='btn btn-secondary'>Borrar</button>
                        </form>
                      </td>";
            }
            echo "</tr>";
        }
    }

    function crearTablaCategorias(){
        $categorias = categoriasToList();

        forEach($categorias as $c){
            echo "<tr>
                    <th scope='row'>".$c[1]."</th>
                    <td>".$c[2]."</td>";
            if ($_SESSION['rol']=="admin"){
                echo "<td style='display:flex; flex_direction:row;gap:5px'>
                        <form method='post' action='categorias_actualizar.php'>
                            <input type='hidden' id='id_categoria' name='id_categoria' value=".$c[0].">
                            <input type='hidden' id='nombre' name='nombre' value=".$c[1].">
                            <input type='hidden' id='descripcion' name='descripcion' value=".$c[2].">
                            <button type='submit' class='btn btn-primary'>Modificar</button>
                        </form>
                        <form method='post' action='categorias_borrar.php'>
                            <input type='hidden' id='id_categoria' name='id_categoria' value=".$c[0].">
                            <button type='submit' class='btn btn-secondary'>Borrar</button>
                        </form>
                      </td>";
            }
            echo "</tr>";
        }
    }

    function crearSelectsCategorias($nombreCategoria = null){
        $categorias = categoriasToList();

        forEach($categorias as $c){
            echo "<option value=".$c[1];
            if ($nombreCategoria==$c[1]){
                echo " selected";
            }
            echo ">".$c[1]."</option>";
        }
    }


    // Gestion de resolucion de Formularios
    function insertCategoriaRedireccion($nombre, $descripcion){
        $respuesta = anadirCategoria($nombre, $descripcion);

        if ($respuesta){
            session_start();
            $_SESSION['mensaje'] = "Categoria añadida";
            
            header('Location: ../categorias_listar.php');
        }
        else {
            session_start();
            $_SESSION['mensaje'] = "Error: No se ha añadido la categoría";
            
            header('Location: ../categorias_insertar.php');
        }        
    }

    function insertProductoRedireccion($nombre,$descripcion,$precio,$nombreCategoria,$magico){
        $respuesta = anadirProducto($nombre,$descripcion,$precio,$nombreCategoria,$magico);

        if ($respuesta){
            session_start();
            $_SESSION['mensaje'] = "Producto añadido";
            
            header('Location: ../productos_listar.php');
        }
        else {
            session_start();
            $_SESSION['mensaje'] = "Error: No se ha añadido el producto";

            header('Location: ../productos_insertar.php');
        } 
    }

    // Borrado de instancias
    function redireccionBorrarProducto($id){
        $respuesta = borrarProducto($id);

        if ($respuesta){
            header('Location: productos_listar.php');
        }
        else {
            session_start();
            $_SESSION['mensaje'] = "Error: No se ha borrado el producto";

            header('Location: productos_listar.php');
        }
    }

    function redireccionBorrarCategoria($id){
        $respuesta = borrarCategoria($id);

        if ($respuesta){
            header('Location: categorias_listar.php');
        }
        else {
            session_start();
            $_SESSION['mensaje'] = "Error: No se ha borrado la categoria";

            header('Location: categorias_listar.php');
        }
    }

    // FUNCIONES DE REDIRIGIR MODIFICACION DE INSTANCIAS
    function modificarProductoRedireccion($id,$nombre,$descripcion,$precio,$nombreCategoria,$magico){
        $respuesta = modificarProducto($id,$nombre,$descripcion,$precio,$nombreCategoria,$magico);

        if ($respuesta){
            header('Location: ../productos_listar.php');
        }
        else {
            session_start();
            $_SESSION['mensaje'] = "Error: No se ha modificado el producto";

            header('Location: ../productos_listar.php');
        }
    }

    function modificarCategoriaRedireccion($id,$nombre,$descripcion){
        $respuesta = modificarCategoria($id,$nombre,$descripcion);

        if ($respuesta){
            header('Location: ../categorias_listar.php');
        }
        else {
            session_start();
            $_SESSION['mensaje'] = "Error: No se ha modificado el categoria";

            header('Location: ../categorias_listar.php');
        }
    }
?>