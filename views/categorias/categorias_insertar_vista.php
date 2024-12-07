<form method='post' action='controlador/formToInsertCategoria.php'>
    <h3>Añadir categoría:</h3>
    <div class='mb-3'>
        <label for='user' class='form-label'>Nombre:</label>
        <input type='text' class='form-control' id='nombre' name='nombre' maxlength=10>
    </div>
    <div class='mb-3'>
        <label for='descripcion' class='form-label'>Descripcion:</label>
        <input type='text' class='form-control' id='descripcion' name='descripcion' maxlength=100>
    </div>
    <button type='submit' class='btn btn-primary'>Añadir</button>
</form>