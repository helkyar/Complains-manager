<?php 
session_start();
if($_SESSION['admin']!=='true') header('location:../View/home.php');

include('../Model/dbConnexion.php');

if(isset($_GET['uid'])){
 
    if($_SESSION['admin']!=='true') {
          $_SESSION['exception'] = '<input class="error msg" value="No está autorizado a borrar este usuario"></input> <br>';
            header('location:../View/users.php');
            die();
    }

    $id = $_GET['uid'];

    $sql="SELECT admin FROM users WHERE userid= ? ";
    $res = mysqli_prepare($connexion, $sql);
    $ok = mysqli_stmt_bind_param($res, "s", $id);
    $ok = mysqli_stmt_execute($res);

    if($ok==false){
        $_SESSION['exception'] = '<input class="error msg" value="No está autorizado a borrar este usuario"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
        die();
    }

    $ok = mysqli_stmt_bind_result($res, $admin);
    mysqli_stmt_fetch($res);
    mysqli_close($connexion);

    if(!$admin){

        $_SESSION['exception'] = '<input class="error msg" value="Usuario no encontrado"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
        die();
    } 

    if ($admin==='true') {
        $_SESSION['exception'] = '<input class="error msg" value="No está autorizado a borrar este usuario"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
        die();
    }

    include('../Model/dbConnexion.php');
    $delU="DELETE FROM users WHERE userid= ? ";
    $delURes = mysqli_prepare($connexion, $delU);
    $ok = mysqli_stmt_bind_param($delURes, "s", $id);
    $ok = mysqli_stmt_execute($delURes); 

    if($ok==false){
        $_SESSION['exception'] = '<input class="error msg" value="No está autorizado a borrar este usuario"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
        die();
    }

    if(mysqli_connect_errno()){
        $_SESSION['exception'] = '<input class="error msg" value="Fallo de conexión"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
        die();

    } else {
        $_SESSION['exception'] = '<input class="success msg" value="Usuario borrado con éxito"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
        die();
    }

} else {
    header('location:../View/users.php');
}
?>