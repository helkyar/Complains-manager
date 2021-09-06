<?php
if(!isset($_SESSION['user'])) header('location:login.php');
 
include('../Model/dbConnexion.php');

// CREATION ==================================================================================
if(isset($_POST['comentCreation'])){
    
    $comment = $_POST['comment'];
    $complainId = $_GET['cid'];
    $idCreator = $_SESSION['userid'];
    $username = $_SESSION['user'];
    $admin = $_SESSION['admin'];

    $count = 0;

    if(!$comment || !$complainId) $count++;

    if($count===0){

        $create = "INSERT INTO comments (username, comment, userid, complainid, admin) VALUES (?, ?, ?, ?, ?)";
        $createRes = mysqli_prepare($connexion, $create);
        $ok = mysqli_stmt_bind_param($createRes, "sssss", $username, $comment, $idCreator, $complainId, $admin);
        $ok = mysqli_stmt_execute($createRes); 

        if($ok==false){
            $_SESSION['createcomm'] = '<input class="error msg comm" value="Error al intruducir el comentario"></input> <br>';
            mysqli_close($connexion);

        } elseif(mysqli_connect_errno()){

            $_SESSION['errcreatecomm'] = '<input class="error msg comm" value="Fallo de conexión"></input> <br>';
            mysqli_close($connexion);
        } else {
            $_SESSION['createcomm']= '<input class="success msg comm" value="Comentario creado"></input> <br>'; 
            mysqli_close($connexion);   
        }

    } else {
        $_SESSION['errcreatecomm'] = '<input class="error msg comm" value="Rellene todos los campos"></input> <br>';
        mysqli_close($connexion);
    }
} 
// DELETION ==================================================================================
    if(isset($_GET['delc'])){

        $commentId = $_GET['delc'];

        $delcom = "DELETE FROM comments WHERE id= ? ";
        $delRes = mysqli_prepare($connexion, $delcom);
        $ok = mysqli_stmt_bind_param($delRes, "s", $commentId);
        $ok = mysqli_stmt_execute($delRes); 

        if($ok==false){
            $_SESSION['createcomm'] = '<input class="error msg" value="Error al eliminzr el comentario"></input> <br>';
            mysqli_close($connexion);
        }

        if(mysqli_connect_errno()){
             $_SESSION['createcomm'] = '<input class="error msg comm" value="Fallo de conexión"></input> <br>';
             mysqli_close($connexion);
             
        } else {
            $_SESSION['createcomm']= '<input class="success msg comm" value="Comentario eliminado"></input> <br>';
            mysqli_close($connexion);
        }
    }


// UPDATE ==================================================================================
    if(isset($_POST['comentUpdate'])){
        $idC = $_POST['idc'];
        $comment = $_POST['comment'];

        $updatec = "UPDATE comments SET comment= ? WHERE id= ? ";
        $updateRes = mysqli_prepare($connexion, $updatec);
        $ok = mysqli_stmt_bind_param($updateRes, "ss", $comment, $idC);
        $ok = mysqli_stmt_execute($updateRes); 

        if($ok==false){
            $_SESSION['createcomm'] = '<input class="error msg" value="Error al actualizar el comentario"></input> <br>';
            mysqli_close($connexion);
        }

        if(mysqli_connect_errno()){
             $_SESSION['createcomm'] = '<input class="error msg comm" value="Fallo de conexión"></input> <br>';
             mysqli_close($connexion);
        } else {
            $_SESSION['createcomm']= '<input class="success msg comm" value="Comentario actualizado"></input> <br>'; 
            mysqli_close($connexion);
        }
    }