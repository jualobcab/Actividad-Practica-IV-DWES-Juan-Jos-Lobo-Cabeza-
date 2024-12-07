<?php 
    include_once "sesiones.php";
    include_once "funciones.php";

    //////////////////////////////////////////////////////////////////////
    /////////////    ABRIR Y CERRAR BASE DE DATOS   //////////////////////
    //////////////////////////////////////////////////////////////////////
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

    /////////////////////////////////////////////////////////////
    /////////////    BUSQUEDA DE USUARIO   //////////////////////
    /////////////////////////////////////////////////////////////
    function comprobacionUsuario($usuario,$contrasenya){
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
        $res = false;
        
        if ($conexion){
            // Si coge una instancia es usuario y contraseña correctos
            $sql = "SELECT * FROM Usuarios WHERE usuario=? AND contrasenya=?";
            $stmt = mysqli_prepare($conexion,$sql);

            if($stmt){
                mysqli_stmt_bind_param($stmt, "ss", $usuario,md5($contrasenya));
                
                mysqli_stmt_execute($stmt);

                $resultado = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($resultado)>0){
                    $fila = mysqli_fetch_assoc($resultado);

                    // Crea la sesion
                    crearSesion($fila['usuario'], $fila['rol']);
                    $res = true;

                    // Actualiza la hora del último acceso
                    $idUser = $fila['id'];
                    $sqlUpdate = "UPDATE Usuarios SET ultimo_acceso = CURRENT_TIMESTAMP WHERE id = ?";
                    $stmtUpdate = mysqli_prepare($conexion, $sqlUpdate);

                    if ($stmtUpdate) {
                        mysqli_stmt_bind_param($stmtUpdate, "i", $idUser);
                        mysqli_stmt_execute($stmtUpdate);
                        mysqli_stmt_close($stmtUpdate);
                    }
                }

                // Cerrar el statement
                mysqli_stmt_close($stmt);
            }
        }

        cerrar_Bd($conexion);
        return $res;
    }


    /////////////////////////////////////////////////////////////////
    ///////////////    LISTADO DE INSTANCIAS   //////////////////////
    /////////////////////////////////////////////////////////////////
    function categoriasToList() {
        $res = [];
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
    
        if ($conexion) {
            // Preparar la consulta SQL
            $sql = "SELECT id_categoria, nombre, descripcion FROM Categorias";
            $stmt = mysqli_prepare($conexion, $sql);
    
            if ($stmt) {
                // Ejecutar la consulta preparada
                mysqli_stmt_execute($stmt);
    
                // Obtener el resultado
                $resultado = mysqli_stmt_get_result($stmt);
    
                // Procesar los resultados
                if (mysqli_num_rows($resultado) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        $arrayAux = [$fila['id_categoria'], $fila['nombre'], $fila['descripcion']];
                        array_push($res, $arrayAux);
                    }
                }
    
                // Cerrar el statement
                mysqli_stmt_close($stmt);
            }
        }
    
        cerrar_Bd($conexion);
        return $res;
    }

    function productosToList() {
        $res = [];
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
    
        if ($conexion) {
            // Preparar la consulta SQL con JOIN en lugar de coma para mayor claridad
            $sql = "SELECT p.*, c.nombre AS nombre_categoria 
                    FROM Productos p 
                    JOIN Categorias c ON p.id_categoria = c.id_categoria";
            
            $stmt = mysqli_prepare($conexion, $sql);
    
            if ($stmt) {
                // Ejecutar la consulta preparada
                mysqli_stmt_execute($stmt);
    
                // Obtener el resultado
                $resultado = mysqli_stmt_get_result($stmt);
    
                // Procesar los resultados
                if (mysqli_num_rows($resultado) > 0) {
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        // Comprobación si el producto es mágico
                        $magico = $fila['magico'] ? "Si" : "No";
    
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
    
                        array_push($res, $arrayAux);
                    }
                }
    
                // Cerrar el statement
                mysqli_stmt_close($stmt);
            }
        }
    
        cerrar_Bd($conexion);
        return $res;
    }
    

    /////////////////////////////////////////////////////////////
    ///////////////    AÑADIR INSTANCIAS   //////////////////////
    /////////////////////////////////////////////////////////////
    function anadirCategoria($nombre, $descripcion) {
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
        $res = false;
    
        if ($conexion) {
            // Preparar la consulta SQL
            $sql = "INSERT INTO Categorias (nombre, descripcion) VALUES (?, ?)";
            $stmt = mysqli_prepare($conexion, $sql);
    
            if ($stmt) {
                // Vincular los parámetros a la consulta preparada (ambos son strings)
                mysqli_stmt_bind_param($stmt, "ss", strip_tags($nombre), strip_tags($descripcion));
    
                // Ejecutar la consulta preparada
                if (mysqli_stmt_execute($stmt)) {
                    $res = true;
                }
    
                // Cerrar el statement
                mysqli_stmt_close($stmt);
            }
        }
    
        cerrar_Bd($conexion);
        return $res;
    }
    

    function anadirProducto($nombre, $descripcion, $precio, $nombreCategoria, $magico) {
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
        $res = false;
    
        if ($conexion) {
            // 1. Preparar la consulta para obtener el ID de la categoría
            $sqlCategoria = "SELECT id_categoria FROM Categorias WHERE nombre = ?";
            $stmtCategoria = mysqli_prepare(strip_tags($conexion), strip_tags($sqlCategoria));
    
            if ($stmtCategoria) {
                // Vincular el parámetro para el nombre de la categoría
                mysqli_stmt_bind_param($stmtCategoria, "s", strip_tags($nombreCategoria));
                
                // Ejecutar la consulta
                mysqli_stmt_execute($stmtCategoria);
                
                // Obtener el resultado
                $resultado = mysqli_stmt_get_result($stmtCategoria);
    
                if ($fila = mysqli_fetch_assoc($resultado)) {
                    $idCat = $fila['id_categoria'];
                    
                    // Cerrar el statement de la categoría
                    mysqli_stmt_close($stmtCategoria);
    
                    // 2. Preparar la consulta para insertar el producto
                    $sqlProducto = "INSERT INTO Productos (nombre, descripcion, precio, id_categoria, magico) VALUES (?, ?, ?, ?, ?)";
                    $stmtProducto = mysqli_prepare($conexion, $sqlProducto);
    
                    if ($stmtProducto) {
                        // Vincular los parámetros para el producto
                        mysqli_stmt_bind_param($stmtProducto, "ssdii", strip_tags($nombre), strip_tags($descripcion), $precio, $idCat, $magico);
    
                        // Ejecutar la consulta de inserción
                        if (mysqli_stmt_execute($stmtProducto)) {
                            $res = true;
                        }
    
                        // Cerrar el statement del producto
                        mysqli_stmt_close($stmtProducto);
                    }
                } else {
                    // Si no se encontró la categoría, cerrar el statement de la categoría
                    mysqli_stmt_close($stmtCategoria);
                }
            }
        }
    
        // Cerrar la conexión
        cerrar_Bd($conexion);
        return $res;
    }
    

    /////////////////////////////////////////////////////////////////
    ///////////////    BORRADO DE INSTANCIAS   //////////////////////
    /////////////////////////////////////////////////////////////////
    function borrarProducto($id) {
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
        $res = false;
    
        if ($conexion) {
            // Preparar la consulta para eliminar el producto por su id
            $sql = "DELETE FROM Productos WHERE id_producto = ?";
            $stmt = mysqli_prepare($conexion, $sql);
    
            if ($stmt) {
                // Vincular el parámetro para el id del producto
                mysqli_stmt_bind_param($stmt, "i", $id);
    
                // Ejecutar la consulta
                if (mysqli_stmt_execute($stmt)) {
                    $res = true;
                }
    
                // Cerrar el statement
                mysqli_stmt_close($stmt);
            }
        }
    
        // Cerrar la conexión
        cerrar_Bd($conexion);
        return $res;
    }
    
    function borrarCategoria($id) {
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
        $res = false;
    
        if ($conexion) {
            // Preparar la consulta para eliminar la categoría por su id
            $sql = "DELETE FROM Categorias WHERE id_categoria = ?";
            $stmt = mysqli_prepare($conexion, $sql);
    
            if ($stmt) {
                // Vincular el parámetro para el id de la categoría
                mysqli_stmt_bind_param($stmt, "i", $id);
    
                // Ejecutar la consulta
                if (mysqli_stmt_execute($stmt)) {
                    $res = true;
                }
    
                // Cerrar el statement
                mysqli_stmt_close($stmt);
            }
        }
    
        // Cerrar la conexión
        cerrar_Bd($conexion);
        return $res;
    }
    

    ////////////////////////////////////////////////////////////////////
    ///////////////    MODIFFICAR DE INSTANCIAS   //////////////////////
    ////////////////////////////////////////////////////////////////////
    function modificarProducto($id, $nombre, $descripcion, $precio, $nombreCategoria, $magico) {
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
        $res = false;
    
        if ($conexion) {
            // Buscar id de la categoría correspondiente
            $sql_categoria = "SELECT id_categoria FROM Categorias WHERE nombre = ?";
            $stmt_categoria = mysqli_prepare($conexion, $sql_categoria);
    
            if ($stmt_categoria) {
                // Vincular el parámetro para el nombre de la categoría
                mysqli_stmt_bind_param($stmt_categoria, "s", strip_tags($nombreCategoria));
    
                // Ejecutar la consulta
                mysqli_stmt_execute($stmt_categoria);
    
                // Obtener el resultado
                mysqli_stmt_bind_result($stmt_categoria, $idCat);
                mysqli_stmt_fetch($stmt_categoria);
    
                // Si no se encuentra la categoría, cerrar y retornar
                if (!$idCat) {
                    mysqli_stmt_close($stmt_categoria);
                    cerrar_Bd($conexion);
                    return $res;
                }
    
                // Cerrar el statement de categoría
                mysqli_stmt_close($stmt_categoria);
            }
    
            // Modificación del producto
            $sql_producto = "UPDATE Productos 
                             SET nombre = ?, descripcion = ?, precio = ?, magico = ?, id_categoria = ? 
                             WHERE id_producto = ?";
            $stmt_producto = mysqli_prepare($conexion, $sql_producto);
    
            if ($stmt_producto) {
                // Vincular los parámetros para la actualización del producto
                mysqli_stmt_bind_param($stmt_producto, "ssdisi", strip_tags($nombre), strip_tags($descripcion), $precio, $magico, $idCat, $id);
    
                // Ejecutar la consulta de actualización
                if (mysqli_stmt_execute($stmt_producto)) {
                    $res = true;
                }
    
                // Cerrar el statement de actualización
                mysqli_stmt_close($stmt_producto);
            }
        }
    
        // Cerrar la conexión
        cerrar_Bd($conexion);
        return $res;
    }
    

    function modificarCategoria($id, $nombre, $descripcion) {
        $conexion = conectar_Bd();
        mysqli_report(MYSQLI_REPORT_OFF);
        $res = false;
    
        if ($conexion) {
            // Consulta de actualización usando Prepared Statements
            $sql = "UPDATE Categorias 
                    SET nombre = ?, descripcion = ? 
                    WHERE id_categoria = ?";
            
            // Preparar la consulta
            $stmt = mysqli_prepare($conexion, $sql);
    
            if ($stmt) {
                // Vincular los parámetros
                mysqli_stmt_bind_param($stmt, "ssi", strip_tags($nombre), strip_tags($descripcion), $id);
    
                // Ejecutar la consulta
                if (mysqli_stmt_execute($stmt)) {
                    $res = true;
                }
    
                // Cerrar el statement
                mysqli_stmt_close($stmt);
            }
        }
    
        // Cerrar la conexión
        cerrar_Bd($conexion);
        return $res;
    }
    
?>