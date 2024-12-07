<form method='post' action='controlador/formToInsertProducto.php'>
    <h3>Añadir producto:</h3>
    <div class='mb-3'>
        <label for='user' class='form-label'>Nombre:</label>
        <input type='text' class='form-control' id='nombre' name='nombre' maxlength=30>
    </div>
    <div class='mb-3'>
        <label for='descripcion' class='form-label'>Descripcion:</label>
        <input type='text' class='form-control' id='descripcion' name='descripcion' maxlength=100>
    </div>
    <div class='mb-3'>
        <label for='precio' class='form-label'>Precio:</label>
        <input type='number' step="0.01" class='form-control' id='precio' name='precio'>
    </div>
    <div class="mb-3 form-check">
        <input class="form-check-input" type="checkbox" value="magico" id="magico" name="magico">
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
                crearSelectsCategorias();
            ?>
        </select>
    </div>
    <button type='submit' class='btn btn-primary'>Añadir</button>
</form>