<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Incidencias</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="login">
    <h1><?php echo $title ?></h1> 
    <?php 
        if(isset($_SESSION['credentials'])){
            echo $_SESSION['credentials'];
            unset($_SESSION['credentials']);
        }
    ?>