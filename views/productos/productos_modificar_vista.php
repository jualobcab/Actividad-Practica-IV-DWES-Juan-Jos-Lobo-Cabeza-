<form method='post' action='controlador/formToModificarProducto.php'>
    <h3>Modificar producto:</h3>

    <!-- input invisible para guardar el ID -->
    <input type="hidden" id="id" name="id" value="<?= $_POST['id_producto']?>">

    <div class='mb-3'>
        <label for='user' class='form-label'>Nombre:</label>
        <input type='text' class='form-control' id='nombre' name='nombre' maxlength=30 value="<?= $_POST['nombre']?>">
    </div>
    <div class='mb-3'>
        <label for='descripcion' class='form-label'>Descripcion:</label>
        <input type='text' class='form-control' id='descripcion' name='descripcion' maxlength=100 value="<?= $_POST['descripcion']?>">
    </div>
    <div class='mb-3'>
        <label for='precio' class='form-label'>Precio:</label>
        <input type='number' step="0.01" class='form-control' id='precio' name='precio' value="<?= $_POST['precio']?>">
    </div>
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" value="magico" id="magico" name="magico" <?php
            if ($_POST['magico']){
                echo "checked";
            }
        ?>>
        <label class="form-check-label" for="magico">
            Mágico
        </label>
    </div>
    <div class='mb-3'>
        <label for="selectCategoria">Categoria</label>
        <select class="form-control" id="selectCategoria" name="selectCategoria">
            <option value="" hidden>Selecciona categoría</option>
            <?php
                include_once "includes/funciones.php";
                crearSelectsCategorias($_POST['categoria']);
            ?>
        </select>
    </div>
    <button type='submit' class='btn btn-primary'>Modificar</button>
</form>