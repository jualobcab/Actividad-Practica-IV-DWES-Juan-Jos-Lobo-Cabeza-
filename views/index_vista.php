<div class="cardsTablas">
    <div class="card text-center" style="width: 18rem;">
        <div class="card-body">
            <h4 class="card-title">Categorías</h4>
            <img src="images/categorias.png" alt="categorias">
            <div>
                <a href="categorias_listar.php" class="btn btn-primary">Listar</a>

                <?php
                    if ($_SESSION['rol']=="admin"){
                        echo "<a href='categorias_insertar.php' class='btn btn-secondary'>Añadir</a>";
                    }    
                ?>

            </div>
        </div>
    </div>

    <div class="card text-center" style="width: 18rem;">
        <div class="card-body">
            <h4 class="card-title">Productos</h4>
            <img src="images/bolsa.png" alt="productos">
            <div>
                <a href="productos_listar.php" class="btn btn-primary">Listar</a>

                <?php
                    if ($_SESSION['rol']=="admin"){
                        echo "<a href='productos_insertar.php' class='btn btn-secondary'>Añadir</a>";
                    }    
                ?>

            </div>
        </div>
    </div>
</div>