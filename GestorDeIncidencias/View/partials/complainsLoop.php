
<div class="users inc">

<?php
    if(isset($_SESSION['modifyomp'])){
        echo $_SESSION['modifyomp'];
        unset($_SESSION['modifyomp']);
    }
?>

<?php

if(!$resEsp) header('location: allComplains.php');

if($resEsp){

// Complains are generated throw loop
    while(mysqli_stmt_fetch($resEsp)){

        if($_SESSION['userid']!==$dbuserid && $admin!=='true') die(); ?>

        <section class="user">
            <a href="complains.php?uid=<?php echo $dbuserid; ?>" class="btn2"> 
                <div class="link"><?php echo $dbusername; ?></div> 
            </a>
            <div class="title">
                <a href="complain.php?cid=<?php echo $dbid; ?>"> <?php echo $dbtitle; ?></a>  
            </div>  
            <div class="name"><?php echo $dbemail; ?></div>
            <div class="date"><?php echo $dbdate; ?></div>

            <form class="complain_form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">

                <input type="hidden" name="complainid" value="<?php echo $dbid; ?>">

                <select class="status <?php echo $dbstatus; ?>" name="status"   
                <?php if($dbstatus=='cancelled') echo "disabled";
                      if($dbstatus=='working' && $admin==='false')  echo "disabled";  
                      if($dbstatus=='resolved' && $admin==='false')  echo "disabled";?>>
                
                    <option 
                    <?php if($dbstatus=='waiting') echo "selected"; ?>
                    <?php if($admin==='false') echo "disabled";?>
                    value="waiting">Pendiente</option>

                    <option 
                    <?php if($dbstatus=='working') echo "selected"; ?>
                    <?php if($admin==='false') echo "disabled";?>
                    value="working">Procesando</option>          

                    <option <?php if($dbstatus=='resolved') echo "selected"; ?> value="resolved">Resuelta</option>
                    
                    <option 
                    <?php if($dbstatus=='cancelled') echo "selected"; ?>
                    <?php if($admin==='true')  echo "disabled";?>
                    value="cancelled">Cancelada</option>
                </select>

                <button class="btn4" name="submit">
                    <img class="delete" src="img/change.svg" alt="enviar"> 
                </button>
            </form>

            <?php if($admin==='true'){ ?>

                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delid=<?php echo $dbid; ?>" class="btn3"> 
                    <img class="delete" src="img/delete.svg" alt="eliminar"> 
                </a>
                
            <?php } ?>
        </section> 

<?php }
    mysqli_close($connexion);
} ?>

</div>
</div>