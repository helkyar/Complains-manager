<?php ($_SESSION['admin']==='true')?$q='allComplains.php':$q='complains.php'; ?>

    <ul>
        <li> <a href="home.php">Home</a></li>
        
        <li> <a href="<?php echo $q; ?>">Incidencias</a></li>
        <?php if($_SESSION['admin']==='true'){ ?>

        <li> <a href="users.php">Usuarios</a></li>
        <li> <a href="register.php">Administradores</a></li>
        
        <?php } ?>
        
        <li> <a href="login.php">Cerrar Sesión</a></li>
    </ul>
 