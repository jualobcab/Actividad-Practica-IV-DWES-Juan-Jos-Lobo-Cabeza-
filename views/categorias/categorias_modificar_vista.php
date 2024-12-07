<form method='post' action='controlador/formToModificarCategoria.php'>
    <h3>Modificar categoría:</h3>

    <!-- input invisible para guardar el ID -->
    <input type="hidden" id="id" name="id" value="<?= $_POST['id_categoria']?>">

    <div class='mb-3'>
        <label for='user' class='form-label'>Nombre:</label>
        <input type='text' class='form-control' id='nombre' name='nombre' maxlength=10 value="<?= $_POST['nombre']?>">
    </div>
    <div class='mb-3'>
        <label for='descripcion' class='form-label'>Descripcion:</label>
        <input type='text' class='form-control' id='descripcion' name='descripcion' maxlength=100 value="<?= $_POST['descripcion']?>">
    </div>
    <button type='submit' class='btn btn-primary'>Modificar</button>
</form>