<!DOCTYPE html>
<html lang='es'>
    <!-- Head y Header -->
    <?php
        $pathHeader = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "views/layout/header.php");
        include_once $pathHeader;
    ?>

    <!-- Dentro del Body -->
    <?php
        include_once "views/categorias/categorias_modificar_vista.php"
    ?>

    <!-- Footer -->
    <?php
        $pathFooter = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "views/layout/footer.php");
        include_once $pathFooter;
    ?>
</html>