<head>

<?php
    // Iniciar la sesión
    session_start();

    // Nombre del archivo actual
    $current_page = basename($_SERVER['PHP_SELF']);

    // Verificar si el usuario no tiene una sesión iniciada
    if (!isset($_SESSION['usuario']) && $current_page !== 'login.php') {
        // Redirigir a login.php
        header('Location: login.php');
        exit(); // Finalizar la ejecución para evitar que el resto del código se ejecute
    }
    if (isset($_SESSION['usuario']) && $current_page == 'login.php'){
        // Redirigir a index.php
        header('Location: index.php');  
        exit(); // Finalizar la ejecución para evitar que el resto del código se ejecute
    }
?>

    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
    <link href='css/style.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz' crossorigin='anonymous'></script>
    <title>Tienda</title>
</head>
<body>
    <header class='d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom text-bg-dark'>
        <div class='col-md-3 mb-2 mb-md-0'>
            <a href='index.php' class='d-inline-flex link-body-emphasis text-decoration-none'>
                <svg class='bi' width='40' height='32' role='img' aria-label='Bootstrap'></svg>
                <img src='images/iconoTienda.png' class='icono' alt='iconoTienda'/>
            </a>
        </div>

    <?php
        if ($current_page !== 'login.php'){
    ?>
            <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
                <li><a href='index.php' class='nav-link px-2 link-secondary'>Home</a></li>
                <li><a href='productos_listar.php' class='nav-link px-2'>Productos</a></li>
                <li><a href='categorias_listar.php' class='nav-link px-2'>Categorías</a></li>
            </ul>
            <div class='col-md-3 text-end'>
                <form action='logout.php'>
                    <button type='submit' class='btn btn-primary btnCerrarSesion'>Cerrar Sesión</button>
                </form>
            </div>
    <?php
        }
    ?>
    </header>
    <main>