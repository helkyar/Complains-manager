<?php
include('partials/menu.php');

include('../Controler/complainsControler.php');
$admin = $_SESSION['admin'];

// Indicates that there are no complains or controler has been skipped
if(!$resEsp) header('location:complains.php');

// Indicates number of entries 
$entries = 6;
?> 

<div class="wrapper">
<h1>Incidencia</h1>

<?php 
include('partials/complainsLoop.php');
echo "<p class='user text'> $dbmessage </p>";

include('../Controler/commentControler.php');
?>
 
<div class="complain_creation comment">
    <?php
        if(isset($_SESSION['errcreatecomm'])){
            echo $_SESSION['errcreatecomm'];
            unset($_SESSION['errcreatecomm']);
        } 
    ?>

  <?php 

    if(!isset($_GET['updc'])){ ?>
        <form action="<?php echo $_SERVER['PHP_SELF'].'?cid='.$_GET['cid'] ?>" method="POST">
            <textarea name="comment" cols="80" rows="1" placeholder="Comentario:"></textarea>

            <button class="btn4" name="comentCreation">
                <img src="img/change.svg" alt="enviar"> 
            </button>
        </form> 
  <?php } ?>
    <div class="comment_wrapper">

        <?php

        // Obtaining comments array -------------------------------------------------
        include('../Model/dbConnexion.php');

        $cId= $_GET['cid'];

        $sql="SELECT username, userid, comment, id, admin FROM comments WHERE complainid= ? ORDER BY id DESC";
        $res = mysqli_prepare($connexion, $sql);
        $ok = mysqli_stmt_bind_param($res, "s", $cId);
        $ok = mysqli_stmt_execute($res);

        if($ok==false){
            $_SESSION['createcomm'] = '<input class="error msg" value="Acceso no autorizado"></input> <br>';
            mysqli_close($connexion);
        }

        $ok = mysqli_stmt_bind_result($res, $user, $userid, $comment, $id, $author);
   
        // Warning msg ------------------------------------------------------------
        if(isset($_SESSION['createcomm'])){
            echo $_SESSION['createcomm'];
            unset($_SESSION['createcomm']);
        } 

        if(!mysqli_connect_errno()){

            $lenth = 0;

            while(mysqli_stmt_fetch($res)){

                $array[$lenth]['msg']=$comment;
                $array[$lenth]['usr']=$user;
                $array[$lenth]['uid']=$userid;
                $array[$lenth]['comid']=$id;
                $array[$lenth]['adm']=$author;

                $lenth++;
            }
            mysqli_close($connexion);
            
        } else {
            echo '<input class="error msg comm" value="Fallo de conexión"></input> <br>';
        }

        // Showing comments according to page request --------------------------------
        $page=0;
        if(isset($_GET['pg'])) {
            $page=$_GET['pg']*$entries;
        }else{$_GET['pg']=0;}

        // Making shure it exists
        if(!isset($_GET['updc'])) $_GET['updc']='c';

        for ($i = $page; $i < ($entries+$page); $i++){
            if($i == $lenth)  break; 

            if($_GET['updc']==$array[$i]['comid']){?>

            <form class="<?php if($array[$i]['adm']=='true') echo 'rigth'; ?>" action="<?php echo $_SERVER['PHP_SELF'].'?cid='.$_GET['cid'].'&pg='.$_GET['pg'];?>" method="POST">

                <input type="hidden" name="idc" value="<?php echo $array[$i]['comid'] ?>">
                <textarea name="comment" cols="20" rows="1" ><?php echo $array[$i]['msg'] ?></textarea>

                <button class="btn4" type="submit" name="comentUpdate">
                    <img src="img/change.svg" alt="enviar"> 
                </button>
            </form> 

            <?php }else{ ?>

            <section class="margin <?php if($array[$i]['adm']=='true') echo 'rigth'; ?>">
                <p><strong> <?php echo $array[$i]['usr'] ?></strong></p>
                <p class="comm_text"><?php echo $array[$i]['msg'] ?></p>

            <?php } 
            
            if($_GET['updc']!=$array[$i]['comid']){

                if($_SESSION['userid']==$array[$i]['uid']){ ?>
                    <a id="small" class="btn4" 
                       href="<?php echo $_SERVER['PHP_SELF'].'?pg='.$_GET['pg'].'&cid='.$_GET['cid'].'&updc='.$array[$i]['comid']; ?>">
                        <img src="img/pencil.svg" alt="enviar"> 
                    </a>
                <?php } 

                if($_SESSION['userid']==$array[$i]['uid'] || $_SESSION['admin']==='true'){ ?>
                    <a class="btn3" id="small"
                       href="<?php echo $_SERVER['PHP_SELF'] .'?pg='.$_GET['pg'].'&cid='.$_GET['cid'].'&delc='.$array[$i]['comid']; ?>" > 
                        <img class="delete" src="img/delete.svg" alt="eliminar"> 
                    </a>
                <?php }
             } 
             ?>
            </section>

        <?php } ?>
    </div>

    <div class="pagination">
        <?php
        // Page selector -------------------------------------------------------------
        $pages = ceil($lenth/$entries);

        for($i=1; $i <= $pages; $i++) { ?> 

            <a href="<?php echo $_SERVER['PHP_SELF'] ?>?pg=<?php echo $i-1 ?>&cid=<?php echo $_GET['cid']; ?>"><?php echo $i; ?></a>

        <?php } ?>
    </div>
</div>

<?php include('partials/footer.php') ?>