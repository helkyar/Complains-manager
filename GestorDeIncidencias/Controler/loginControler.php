<?php 
if(!isset($_POST['submit'])) header('location: ../View/login.php');
include('../Model/dbConnexion.php');
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if($username==='admin' && $password==='admin') $createAdmin = 'true';

// Check for blank inputs -----------------------------------------------
if ($username && $password) {
    $sql = "SELECT admin, userid, email, password FROM users WHERE username= ? ";
    $res = mysqli_prepare($connexion, $sql);
    $ok = mysqli_stmt_bind_param($res, "s", $username);
    $ok = mysqli_stmt_execute($res);

    if($ok==false){
        $_SESSION['credentials'] = '<input class="error msg" value="Credenciales incorrectas"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/login.php');
        die();
    }

    $ok = mysqli_stmt_bind_result($res, $admin, $userid, $email, $cryppassword);
    mysqli_stmt_fetch($res);

// First admin creation ===================================================
    if(!$userid && $createAdmin==='true'){
        $passwordFinal = password_hash($password, PASSWORD_DEFAULT);
        $insert="INSERT INTO users (name, surname, username, email, password, admin) VALUES ('Root', 'User', 'admin', 'admin@email.com', '$passwordFinal', 'true')";
        $insertRes = mysqli_query($connexion, $insert); 
    
        if(mysqli_connect_errno()){
            $_SESSION['credentials'] = '<input class="error" value="Error de conexión"></input> <br>';
            mysqli_close($connexion);
            header('location: ../View/login.php');
        } else {
            $_SESSION['credentials'] = '<input class="success" value="Administrador creado con éxito"></input> <br>';
            mysqli_close($connexion);
            header('location: ../View/login.php');
            die();
        }
    }
// First admin creation end ===============================================

//Authenticator ----------------------------------------------------------
    if(!$userid){
        $_SESSION['credentials'] = '<input class="error" value="Credenciales incorrectas"></input> <br>';
        mysqli_close($connexion);
        header('location: ../View/login.php');
    }

    if(password_verify($password, $cryppassword)) {
        $_SESSION['user']=$username;
        $_SESSION['admin']=$admin;
        $_SESSION['userid']=$userid;
        $_SESSION['email']=$email;
        mysqli_close($connexion);
        header('location: ../View/home.php');

    } else {
        $_SESSION['credentials'] = '<input class="error" value="Credenciales incorrectas"></input> <br>';
        mysqli_close($connexion);
        header('location: ../View/login.php');
    }

   
} else {
    $_SESSION['credentials'] = '<input class="error" value="Rellene todos los campos"></input> <br>';
    header('location: ../View/login.php');
}

?>