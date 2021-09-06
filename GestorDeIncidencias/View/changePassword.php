<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location:login.php');

    $title = 'Cambiar Contraseña';
    include('partials/acces.php');
?>

    <form action="" method="POST">

        <label for="curpassword">Contraseña Actual:</label> <br>
        <input type="password" name="curpassword" id="curpassword"> <br>

        <label for="password">Nueva Contraseña:</label> <br>
        <input type="password" name="password" id="password"> <br>

        <label for="repassword">Confirmar contraseña:</label> <br>
        <input type="password" name="repassword" id="repassword"> <br>

        <input type="submit" name="submit" value="Cambiar"></input>
    </form>

    




<?php include('partials/footer.php') ?>