<?php 
if(!isset($_POST['submit'])) header('location: ../View/register.php');
include('../Model/dbConnexion.php');
session_start();
 
$name =  $_POST['name'];
$surname =  $_POST['surname'];
$username =  $_POST['username'];
$email =  $_POST['email'];
$password =  $_POST['password'];
$repassword =  $_POST['repassword'];

// Check for blanks ------------------------------------------------------
if (!$name || !$surname || !$username || !$email || !$password || !$repassword) {

    $_SESSION['credentials'] = '<input class="error" value="Rellene todos los campos"></input> <br>';
    header('location: ../View/register.php');
    die();
}

// Check for user/email repetitions ----------------------------------------

$sql = "SELECT username, email FROM users WHERE username= ? OR email= ? ";
$resp = mysqli_prepare($connexion, $sql); 
$ok = mysqli_stmt_bind_param($resp, "ss", $username, $email);
$ok = mysqli_stmt_execute($resp);

if($ok==false){
        $_SESSION['credentials'] = '<input class="error" value="Error. Inténtelo de nuevo"></input> <br>';
        mysqli_close($connexion);
        header('location: ../View/register.php');
        die();
}

$ok = mysqli_stmt_bind_result($resp, $coincUsername, $coincEmail);
mysqli_stmt_fetch($resp);
mysqli_close($connexion);
  
if($coincUsername){
    $_SESSION['credentials'] = '<input class="error" value="Usuario no disponible"></input> <br>';
    mysqli_close($connexion);
    header('location: ../View/register.php');
    die();

} elseif ($coincEmail){
    $_SESSION['credentials'] = '<input class="error" value="Su correo ya está registrado"></input> <br>';
    mysqli_close($connexion);
    header('location: ../View/register.php');
    die();
}

// Check & encrypt password -------------------------------------------------
if ($password === $repassword) {
    $passwordFinal = password_hash($password, PASSWORD_DEFAULT);
        
    $admin = 'false';
    if ($_SESSION['admin']==='true')  $admin = 'true';

    include('../Model/dbConnexion.php');

    $insert="INSERT INTO users (name, surname, username, email, password, admin) VALUES (?,?,?,?,?,?)";
    $insertRes = mysqli_prepare($connexion, $insert); 
    $ok = mysqli_stmt_bind_param($insertRes, "ssssss", $name, $surname, $username, $email, $passwordFinal, $admin);
    $ok = mysqli_stmt_execute($insertRes);

    if($ok==false){
        $_SESSION['credentials'] = '<input class="error" value="Error. Inténtelo de nuevo"></input> <br>';
        mysqli_close($connexion);
        header('location: ../View/register.php');
        die();
    }

    if(mysqli_connect_errno()){
        $_SESSION['credentials'] = '<input class="error" value="Fallo de conexión"></input> <br>';
        mysqli_close($connexion);
        header('location: ../View/register.php');
        die();
        
    } else {        
        $_SESSION['credentials'] = '<input class="success" value="Registrado con éxito"></input> <br>'; 
        
        if($_SESSION['admin']==='true')  {
            mysqli_close($connexion);
            header('location: ../View/register.php');
            die();
        
        } else {
            mysqli_close($connexion);
            header('location: ../View/login.php');
            die();
        }
    }
} else {
    $_SESSION['credentials'] = '<input class="error" value="Contraseñas no coinciden"></input> <br>';
    header('location: ../View/register.php');
}

?>