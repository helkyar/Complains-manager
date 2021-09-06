<?php
if(!isset($_SESSION['user'])) header('location:login.php');

 
include('../Model/dbConnexion.php');

// CREATION ==================================================================================
if(isset($_POST['creation'])){
    $title = $_POST['title'];
    $message = $_POST['message'];
    $idCreator = $_SESSION['userid'];
    $emailCreator = $_SESSION['email'];
    $username = $_SESSION['user'];

    $count = 0;

    if(!$title || !$message) $count++;

    if($count===0){

        $create = "INSERT INTO complains (username, title, message, userid, email) VALUES (?, ?, ?, ?, ?)";
        $createRes= mysqli_prepare($connexion, $create);
        $ok = mysqli_stmt_bind_param($createRes, "sssss", $username, $title, $message, $idCreator, $emailCreator);
        $ok = mysqli_stmt_execute($createRes);

        if($ok==false){
            $_SESSION['createcomp'] = '<input class="error msg" value="Error al crear incidencia"></input> <br>';
            mysqli_close($connexion);
        }

      if(mysqli_connect_errno()){
            $_SESSION['createcomp'] = '<input class="error msg" value="Fallo de conexión"></input> <br>';
        } else {
            $_SESSION['createcomp']= '<input class="success msg" value="Incidencia creada"></input> <br>';    
        }
    } else {
    $_SESSION['createcomp'] = '<input class="error msg" value="Rellene todos los campos"></input> <br>';
    }
}

// UPDATE ====================================================================================

if(isset($_POST['status'])){

    $sendStatus = mysqli_real_escape_string($connexion, $_POST['status']);
    $id = mysqli_real_escape_string($connexion, $_POST['complainid']);

    // Update Acces ------------------------------------------------------

    $acces="SELECT userid, status FROM complains WHERE id= ? ";
    $accesRes = mysqli_prepare($connexion, $acces);
    $ok = mysqli_stmt_bind_param($accesRes, "s", $id);
    $ok = mysqli_stmt_execute($accesRes);

    if($ok==false){
        $_SESSION['modifyomp'] = '<input class="error msg" value="No está autorizado a actualizar esta incidencia"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
    }

    $ok = mysqli_stmt_bind_result($accesRes, $dbUserid, $status);
    mysqli_stmt_fetch($accesRes);
    mysqli_close($connexion);

    $admin = $_SESSION['admin'];
    $userid = $_SESSION['userid'];

    $count= 0;

    if($status==='cancelled') $count++;
    if($admin!=='true' && $userid!==$dbUserid) $count++;
    if($userid==$dbUserid && $status!=='waiting') $count++;
    if($sendStatus!=='cancelled' && $sendStatus!=='waiting' && $sendStatus!=='working' && $sendStatus!=='resolved') $count++;

    // --------------------------------------------------------------------
    if($count===0){
        include('../Model/dbConnexion.php');

        $update="UPDATE complains SET status= ? WHERE id= ? ";
        $updateRes = mysqli_prepare($connexion, $update);
        $ok = mysqli_stmt_bind_param($updateRes, "ss", $sendStatus, $id);
        $ok = mysqli_stmt_execute($updateRes);

        if($ok==false){
            $_SESSION['modifyomp'] = '<input class="error msg" value="Error al actualizar incidencia"></input> <br>';
            mysqli_close($connexion);
        }

        if(mysqli_connect_errno()){
            $_SESSION['modifyomp'] = '<input class="error msg" value="Fallo de conexión"></input> <br>';
        } else {
            $_SESSION['modifyomp']= '<input class="success msg" value="Incidencia actualizada"></input> <br>';
        }
    } else {
        $_SESSION['modifyomp']= '<input class="error msg" value="Operación no autorizada"></input> <br>';
    }
}


// DELETE ====================================================================================
if(isset($_GET['delid'])){
    if($_SESSION['admin']==='true') {
        $complainId = $_GET['delid'];

        $delComplain = "DELETE FROM complains WHERE id= ? ";
        $delRes = mysqli_prepare($connexion, $delComplain);
        $ok = mysqli_stmt_bind_param($delRes, "s", $complainId);
        $ok = mysqli_stmt_execute($delRes);

         if($ok==false){
            $_SESSION['modifyomp'] = '<input class="error msg" value="Error al eliminar incidencia"></input> <br>';
            mysqli_close($connexion);
        }

        if(mysqli_connect_errno()){
            $_SESSION['modifyomp'] = '<input class="error msg" value="Fallo de conexión"></input> <br>';
        } else {
            $_SESSION['modifyomp'] = '<input class="success msg" value="Incidencia borrada con éxito"></input> <br>';
        }
    }
} 

// SPECIFIC USER =============================================================================
if(isset($_GET['uid'])){
    if($_SESSION['admin']==='true') {
        $userid = $_GET['uid'];

        $comp = "SELECT userid, message, email, date, id, username, status, title FROM complains WHERE userid= ? ORDER BY status DESC";
        $resEsp = mysqli_prepare($connexion, $comp);
        $ok = mysqli_stmt_bind_param($resEsp, "s", $userid);
        $ok = mysqli_stmt_execute($resEsp);

        if($ok==false){
            $_SESSION['modifyomp'] = '<input class="error msg" value="No está autorizado a ver esta incidencia"></input> <br>';
            mysqli_close($connexion);
            header('location:../View/users.php');
        }

        $ok = mysqli_stmt_bind_result($resEsp, $dbuserid, $dbmessage, $dbemail, $dbdate, $dbid, $dbusername, $dbstatus, $dbtitle );  

        if(mysqli_connect_errno()){
            $_SESSION['modifyomp'] = '<input class="error msg" value="Fallo de conexión"></input> <br>';
        }
    }
} 

// SPECIFIC COMPlAIN ==========================================================================
if(isset($_GET['cid'])){
    
    $compid = $_GET['cid'];

    $comp = "SELECT userid, message, email, date, id, username, status, title FROM complains WHERE id= ? ORDER BY status DESC";
    $resEsp = mysqli_prepare($connexion, $comp);
    $ok = mysqli_stmt_bind_param($resEsp, "s", $compid);
    $ok = mysqli_stmt_execute($resEsp);

    if($ok==false){
        $_SESSION['modifyomp'] = '<input class="error msg" value="No está autorizado a ver esta incidencia"></input> <br>';
        mysqli_close($connexion);
        header('location:../View/users.php');
    }

    $ok = mysqli_stmt_bind_result($resEsp, $dbuserid, $dbmessage, $dbemail, $dbdate, $dbid, $dbusername, $dbstatus, $dbtitle );

    if(mysqli_connect_errno()){
        $_SESSION['modifyomp'] = '<input class="error msg" value="Fallo de conexión"></input> <br>';
    }
}
?>