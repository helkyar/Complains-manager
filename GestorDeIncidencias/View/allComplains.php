<?php
include('partials/menu.php');
if($_SESSION['admin']!=='true') header('location:home.php');

include('../Controler/complainsControler.php');
$admin = $_SESSION['admin'];
?>

<div class="wrapper">
<h1>Incidencias</h1>

<?php
$allwaysTrue = -1;

$allcomp = "SELECT userid, message, email, date, id, username, status, title FROM complains WHERE userid > ? ORDER BY status DESC";
$resEsp = mysqli_prepare($connexion, $allcomp);
$ok = mysqli_stmt_bind_param($resEsp, "i", $allwaysTrue);
$ok = mysqli_stmt_execute($resEsp);

if($ok==false){
    $_SESSION['modifyomp'] = '<input class="error msg" value="No está autorizado a ver esta incidencia"></input> <br>';
    mysqli_close($connexion);
    header('location:../View/users.php');
}

$ok = mysqli_stmt_bind_result($resEsp, $dbuserid, $dbmessage, $dbemail, $dbdate, $dbid, $dbusername, $dbstatus, $dbtitle );

include('partials/complainsLoop.php');

include('partials/footer.php') 
?> 