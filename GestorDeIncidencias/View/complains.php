<?php
include('partials/menu.php');

include('../Controler/complainsControler.php');
$admin = $_SESSION['admin'];
?>

<div class="wrapper">
<h1>Incidencias</h1>

<div class="complain_creation">
    <?php
        if(isset($_SESSION['createcomp'])){
            echo $_SESSION['createcomp'];
            unset($_SESSION['createcomp']);
        }

        if($admin!=='true') {?>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <label for="title">Título:</label>
                <input class="title" type="text" id="title" name="title" 
                placeholder="Máximo de 50 carácteres" > <br>

                <textarea name="message" rows="3" cols="100" placeholder="Mensaje:"></textarea>

                <button class="btn4" name="creation"> <img src="img/change.svg" alt="enviar"> </button>
            </form>
            

    <?php } ?>
</div>

<?php
if($admin!=='true'){
    $userid=$_SESSION['userid'];

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

}

include('partials/complainsLoop.php');

include('partials/footer.php') 
?>