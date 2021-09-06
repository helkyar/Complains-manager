<?php
    session_start();
    session_destroy();

    $title = 'Iniciar Sesión';
    include('partials/acces.php');
?>

    <form action="../Controler/loginControler.php" method="POST">

       
    
        <label for="username">Usuario:</label> <br>
        <input type="text" name="username" id="username"> <br>

        <label for="password">Contraseña:</label> <br>
        <input type="password" name="password" id="password"> <br>

        <input type="submit" name="submit" value="Entrar"></input>
    </form>
    <p>¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
</div>
</body>
</html>