<?php 
    include_once "sesiones.php";
    include_once "funciones.php";

    // ABRIR Y CERRAR BASE DE DATOS
    function conectar_Bd(){
        $host = "localhost";
        $usuario = "gamemaster";
        $password = "1111";
        $bd = 'tienda';
        $conexion = mysqli_connect($host, $usuario, $password, $bd);

        return $conexion;
    }
    function cerrar_Bd($conexion){
        mysqli_close($conexion);
    }


    // BUSQUEDA DE USUARIO
    function comprobacionUsuario($usuario,$contrasenya){
        $conexion = conectar_Bd();
        $res = false;
        
        if ($conexion){
            $sql = "SELECT * FROM Usuarios WHERE usuario='$usuario' AND contrasenya='".(md5($contrasenya))."';";
            $encontrado = mysqli_query($conexion,$sql);

            if (mysqli_num_rows($encontrado)>0){
                while($fila = mysqli_fetch_assoc($encontrado)){
                    //if ($contrasenya == $fila['contrasenya']){
                    crearSesion($fila['usuario'],$fila['rol']);
                    $res = true;

                    // Actualiza la hora a la que se conecto por ultima vez
                    $idUser = $fila['id'];
                    $sql = "UPDATE TABLE Usuarios SET ultimo_acceso=(CURRENT_TIMESTAMP) WHERE id='$idUser';";
                    //}
                }
            }
        }

        cerrar_Bd($conexion);
        return $res;
    }


    // Listar categorias
    function categoriasToList(){
        $res = [];
        $conexion = conectar_Bd();

        if($conexion){
            $sql = "SELECT * FROM Categorias;";
            $respuesta = mysqli_query($conexion,$sql);

            if (mysqli_num_rows($respuesta)>0){
                while($fila = mysqli_fetch_assoc($respuesta)){
                    $arrayAux = [$fila['id_categoria'],$fila['nombre'],$fila['descripcion']];
                    array_push($res,$arrayAux);
                }
            }
        }

        cerrar_Bd($conexion);
        return $res;
    }

    function productosToList(){
        $res = [];
        $conexion = conectar_Bd();

        if($conexion){
            $sql = "SELECT p.*, c.nombre as 'nombre_categoria' FROM Productos p, Categorias c WHERE p.id_categoria=c.id_categoria;";
            $respuesta = mysqli_query($conexion,$sql);

            if (mysqli_num_rows($respuesta)>0){
                while($fila = mysqli_fetch_assoc($respuesta)){
                    // Comprobacion si es o no magico
                    if($fila['magico']){
                        $magico="Si";   
                    }
                    else{
                        $magico="No";
                    }

                    // Creación del array auxiliar
                    $arrayAux = [
                        $fila['id_producto'],
                        $fila['nombre'],
                        $fila['descripcion'],
                        $fila['precio'],
                        $magico,
                        $fila['fechaAnadido'],
                        $fila['nombre_categoria']
                    ];
                    array_push($res,$arrayAux);
                }
            }
        }

        cerrar_Bd($conexion);
        return $res;
    }

    // Añadir instancias
    function anadirCategoria($nombre, $descripcion){
        $conexion= conectar_Bd();
        $res = false;

        $sql="INSERT into Categorias(nombre, descripcion) VALUES ('".($nombre)."', '".($descripcion)."');";
        mysqli_report(MYSQLI_REPORT_OFF);
        
        if ($conexion){
            if (mysqli_query($conexion,$sql)){
                $res = true;
            }
        }

        cerrar_Bd($conexion);
        return $res;
    }

    function anadirProducto($nombre,$descripcion,$precio,$nombreCategoria,$magico){
        $conexion= conectar_Bd();
        $res = false;
        
        // Buscador de id del nombre de categoria correspondiente
        $sql = "SELECT * FROM Categorias c WHERE c.nombre='".$nombreCategoria."';";
        $respuesta = mysqli_query($conexion,$sql);

        if (mysqli_num_rows($respuesta)>0){
            while($fila = mysqli_fetch_assoc($respuesta)){
                $idCat = $fila['id_categoria'];
            }
        }
        else {
            cerrar_Bd($conexion);
            return $res;
        }

        // Insertar el producto
        $sql2="INSERT into Productos(nombre,descripcion,precio,id_categoria,magico) VALUES ('".$nombre."', '".$descripcion."', ".$precio.", ".$idCat.", ".$magico.");";
        mysqli_report(MYSQLI_REPORT_OFF);
        
        if ($conexion){
            if (mysqli_query($conexion,$sql2)){
                $res = true;
            }
        }

        cerrar_Bd($conexion);
        return $res;
    }

    // Borrado de productos
    function borrarProducto($id){
        $conexion = conectar_Bd();
        $res = false;

        $sql = "DELETE FROM Productos WHERE id_producto=".$id.";";
        mysqli_report(MYSQLI_REPORT_OFF);

        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            $res = true;
        }

        cerrar_Bd($conexion);
        return $res;
    }
    function borrarCategoria($id){
        $conexion = conectar_Bd();
        $res = false;

        $sql = "DELETE FROM Categorias WHERE id_categoria=".$id.";";
        mysqli_report(MYSQLI_REPORT_OFF);

        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            $res = true;
        }

        cerrar_Bd($conexion);
        return $res;
    }

    // MODIFICAR LAS INSTANCIAS
    function modificarProducto($id,$nombre,$descripcion,$precio,$nombreCategoria,$magico){
        $conexion = conectar_Bd();
        $res = false;

        // Buscador de id del nombre de categoria correspondiente
        $sql = "SELECT * FROM Categorias c WHERE c.nombre='".$nombreCategoria."';";
        $respuesta = mysqli_query($conexion,$sql);

        if (mysqli_num_rows($respuesta)>0){
            while($fila = mysqli_fetch_assoc($respuesta)){
                $idCat = $fila['id_categoria'];
            }
        }
        else {
            cerrar_Bd($conexion);
            return $res;
        }

        // Modificacion del producto
        $sql = "UPDATE Productos 
                SET nombre='".$nombre."',
                    descripcion='".$descripcion."',
                    precio='".$precio."',
                    magico='".$magico."',
                    id_categoria='".$idCat."'
                WHERE id_producto=".$id.";";
        mysqli_report(MYSQLI_REPORT_OFF);

        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            $res = true;
        }

        cerrar_Bd($conexion);
        return $res;
    }

    function modificarCategoria($id,$nombre,$descripcion){
        $conexion = conectar_Bd();
        $res = false;

        // Modificacion del producto
        $sql = "UPDATE Categorias 
                SET nombre='".$nombre."',
                    descripcion='".$descripcion."'
                WHERE id_categoria=".$id.";";
        mysqli_report(MYSQLI_REPORT_OFF);

        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            $res = true;
        }

        cerrar_Bd($conexion);
        return $res;
    }
?>