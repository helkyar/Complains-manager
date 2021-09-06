
<?php include('partials/menu.php'); ?>

<div class="home">
<h1>¡Bienbenid@  <span><?php echo  $_SESSION['user']; ?></span>!</h1>

<?php if($_SESSION['admin']==='true') { ?>

        <h4>¿Listo para resolver nuevas incidencias?</h4>
        <a class='btn' href='allComplains.php'> ¡Por supuesto! </a>

<?php } else { ?>

        <h4>¿Vienes a quejarte de nuevo?</h4>
        <a class='btn' href='complains.php'> ¡Por supuesto! </a>

<?php } ?>

</div>


<?php include('partials/footer.php') ?>