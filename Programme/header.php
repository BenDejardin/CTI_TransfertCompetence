<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nomPage; ?></title>
    <link href="<?php for($i=0; $i<$nbSaut; $i++){ echo "../"; } ?>bootstrap-5.1.3-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php for($i=0; $i<$nbSaut; $i++){ echo "../"; } ?>style.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="<?php for($i=0; $i<$nbSaut; $i++){ echo "../"; } ?>bootstrap-5.1.3-dist/js/bootstrap.js"></script>
    <script src="<?php for($i=0; $i<$nbSaut; $i++){ echo "../"; } ?>script.js"></script>
</head>

<body>

<?php
    //require('fonction.php');
    //$include =  "Includes/globals.php" ;
    //for($i=0; $i<$nbSaut; $i++){ $include = "../".$include; } 
    //require($include);

    /* On recupère les infos du user connecté*/
    //$service->getUser();
    //$idUser = $service->idUser;
    //$nomPrenomUser = $service->nomPrenom;

    // Récupère le role de la personne connercté 
    //$role = getRole($nomPrenomUser)[0]->role;
    // print_r('Connecter en tant que : '.$role);

    if (isset($_POST['login'])) {

        require('fonction.php');    
    
        $nomPrenomUser = $_POST['ident'];
    
        session_start();
        $role = getRole($_POST['ident']);
        $_SESSION['role'] = "Responsable";
    
        if ($role == null && $_POST['ident'] != null) {
            $query = "INSERT INTO `role`(`nom_prenom`, `role`) VALUES ('$nomPrenomUser', 'Agent')";
            $pdo->query($query);
            $_SESSION['role'] = "Agent";
        }
    
        header('Location: index.php');
    }


    if(!session_status()){
        session_start();
    }
    
    if(isset($_SESSION['role'])){
        $role = $_SESSION['role'];
    }

?>

    <!-- Header -->
    <div class="container">
        <nav class="navbar">
            <div class="d-flex justify-content-start">
                <a class="navbar-brand logo" href="<?php for($i=1; $i<$nbSaut; $i++){ echo "../"; } ?>index.php">
                    <img class="" src="<?php for($i=0; $i<$nbSaut; $i++){ echo "../"; } ?>img/logo.png" alt="" width="100%">
                </a>
                <h1 class="title align-self-center"><?php echo $nomPage; ?></h1>
            </div>
        </nav>
    </div>

      <!-- Extension jquery -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
     <!-- Extension DATEPICKER -->
     <script
         src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>