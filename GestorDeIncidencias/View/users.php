<!-- FALTA ERROR PG ========================================================================== -->

<?php
include('partials/menu.php');
if($_SESSION['admin']!=='true') header('location:home.php');
?>

<div class="wrapper">
<h1>Usuarios</h1>
<div class="users">

<?php 
    if(isset($_SESSION['exception'])){
        echo $_SESSION['exception'];
        unset($_SESSION['exception']);
    }
?>

<?php
include('../Model/dbConnexion.php');
$sql = "SELECT * FROM users ORDER BY admin DESC";
$res = mysqli_query($connexion, $sql);

if(mysqli_num_rows($res) > 0){

    while($row=mysqli_fetch_assoc($res)){ ?>

    <section class="user">
    <a href="complains.php?uid=<?php echo $row['userid'] ?>" class="btn2"> <div class="link"><?php echo $row['username']; ?></div> </a>
    <div class="name"><?php echo $row['name']." ".$row['surname'] ?></div>  
    <div class="mail"><?php echo $row['email']?></div> 

    <?php if($row['admin']==='true') {?> 
        <div class="admin">Administrador</div>

    <?php } else {?>
        <div class="noadmin">Usuario</div>
        <a href="../Controler/deleteUser.php?uid=<?php echo $row['userid'] ?>" class="btn3">  
        <img class="delete" src="img/delete.svg" alt="eliminar">   </a>
    <?php } ?>

</section> 

<?php } } else {
 include('partials/error.php');  
}?>

<!-- Página de errores -->

</div>
</div>

<?php include('partials/footer.php') ?>