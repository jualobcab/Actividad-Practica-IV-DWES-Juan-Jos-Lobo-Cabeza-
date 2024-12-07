<!DOCTYPE html>
<html lang='es'>
    <!-- Head y Header -->
    <?php
        $pathHeader = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "views/layout/header.php");
        include_once $pathHeader;
    ?>

    <!-- Dentro del Body -->
    <?php
        $pathLogin = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "views/login_vista.php");
        include_once $pathLogin;
    ?>

    <!-- Footer -->
    <?php
        $pathFooter = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, "views/layout/footer.php");
        include_once $pathFooter;
    ?>
</html>