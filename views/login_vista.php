<form method='post' action='controlador/formToLogin.php'>
    <div class='mb-3'>
        <label for='user' class='form-label'>Usuario:</label>
        <input type='text' class='form-control' id='user' name='user' required>
    </div>
    <div class='mb-3'>
        <label for='contrasenya' class='form-label'>Contraseña:</label>
        <input type='password' class='form-control' id='contrasenya' name='contrasenya' required>
    </div>
    <button type='submit' class='btn btn-primary'>Login</button>
</form>