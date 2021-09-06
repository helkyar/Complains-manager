<?php
    session_start();
        
    $title = 'Registrarse';

    if (isset($_SESSION['admin'])){

        if ($_SESSION['admin']==='true') {

            $title = 'Registrar Administrador';
            include('partials/navbar.php');

        } else {
            session_destroy(); 
        }
    } 

    include('partials/acces.php');
?>