<table>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Nombre</th>
      <th scope="col">Descripcion</th>
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
        crearTablaCategorias();
    ?>

  </tbody>
</table>
</table