<table>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
      <th scope="col">Precio</th>
      <th scope="col">Mágico</th>
      <th scope="col">Fecha Añadido</th>
      <th scope="col">Categoría</th>
      <?php
        if ($_SESSION['rol']=="admin"){
            echo "<th scope='col'></th>";
        }
      ?>
    </tr>
  </thead>
  <tbody>
    
    <!-- Pintar tabla -->
    <?php
        include_once "includes/funciones.php";
        crearTablaProductos();
    ?>

  </tbody>
</table>
</table