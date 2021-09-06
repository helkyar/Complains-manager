<?php 
    include('../Controler/registerAcces.php'); 
    $register = 'Regístrate';
    if(isset($_SESSION['admin']))  $register = 'Registrar administrador';
    
?>

    <form action="../Controler/registerControler.php" method="POST">

        <label for="name">Nombre:</label> <br>
        <input type="text" name="name" id="name" placeholder="Joaquín"> <br>

        <label for="surname">Apellido:</label> <br>
        <input type="text" name="surname" id="surname" placeholder="Montermoso"> <br>

        <label for="username">Usuario:</label> <br>
        <input type="text" name="username" id="username" placeholder="Máximo 10 carácteres"> <br>

        <label for="email">Correo:</label> <br>
        <input type="email" name="email" id="email" placeholder="email@ejemplo.com"> <br>

        <label for="password">Contraseña:</label> <br>
        <input type="password" name="password" id="password" placeholder="**********"> <br>

        <label for="repassword">Confirmar contraseña:</label> <br>
        <input type="password" name="repassword" id="repassword" placeholder="**********"> <br>

        <input type="submit" name="submit" value="<?= $register ?>"></input>
    </form>

<?php 
    if(!isset($_SESSION['user'])) 
      echo "<p>¿Ya tienes cuenta? <a href='login.php'>Iniciar sesión</a></p>";
?>

</div>

<?php if(isset($_SESSION['user']))  include('partials/footer.php') ?>
