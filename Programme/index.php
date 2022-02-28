<?php

// Titre de la page
$nomPage = "Transfert de Compétences";

// Nombre de saut avant d'atteindre les assets
$nbSaut = 1;

require('header.php');


// Récupération des information de création pour enregistrer dans la BDD
if (isset($_POST['Creation'])) { ?>

    <script>
        setTimeout("showAlerte()", 2000); // Affiche le message d'alerte durant 2 sec  
    </script>
    <!-- Message d'alerte -->
    <div id="alerte" class="alert alert-success text-center" role="alert">
        La fiche de Transfert de Compétences a bien été créer
    </div>

    <?php

    // Si nous avons 2 Tuteur ont fusionne les deux sous forme Tuteur1 / Tuteur2 
    if (is_array($_POST['nomTuteur']) && count($_POST['nomTuteur']) == 2) {
        $nomTuteur = $_POST['nomTuteur'][0] . ' / ' . $_POST['nomTuteur'][1];
    } else {
        $nomTuteur = $_POST['nomTuteur'];
    }

    // Récupère le tableau des dateDeb qui peut etre dateDeb[0] => undefined dateDeb[7] => '12/01/2022' a cause de la suppression de ligne
    // Donc on recupere les informations et ont les replaces corectement 
    $index = 0;
    foreach ($_POST['dateDeb'] as $dateDeb) {
        $dateDeb = dateFR2EN($dateDeb); // On convertie notre date FR en EN pour la BDD 
        $tabDateDeb[$index] = $dateDeb;
        $index++;
    }
    $index = 0;
    foreach ($_POST['Objectif'] as $objectif) {
        $tabObjectif[$index] = $objectif;
        $index++;
    }
    $index = 0;
    foreach ($_POST['dateFin'] as $dateFin) {
        $dateFin = dateFR2EN($dateFin);
        $tabDateFin[$index] = $dateFin;
        $index++;
    }

    $objG = $_POST['ObjectifG'];
    $date = date('Y-m-d'); // Date d'aujourdhui sous format EN  
    $nbTransfCpts = getNbTransfCpts();

    $nomResponsable = $nomPrenomUser;  // La création est accessible qu'aux responsable alors ont sais que nom de personne connecté = nom Responsable
    $nomAgent = $_POST['nomAgent'];

    $domaine = $_POST['domaine'];
    $secteur = $_POST['secteur'];


    // Insert dans la BDD l'ensemble des ligne du tableau de compétences 
    for ($i = 0; $i < $index; $i++) {

        $query = "INSERT INTO `competences`(`id_TCs`, `date_debut`, `objectif`, `date_fin`, `etat`, `pourcentage`, `commentaire`) VALUES ($nbTransfCpts,'$tabDateDeb[$i]'," . '"' . $tabObjectif[$i] . '"' . ",'$tabDateFin[$i]','En Cours',0,'')";
        $pdo->query($query);
    }

    // Insert l'ensemble des données récupérer dans la BDD
    $query2 = "INSERT INTO `transfert_competences`(`id_TCs`, `objectif_global`, `choix_validation`, `etat`, `date_creation`, `date_cloture`,`pourcentageGlobal`) VALUES ($nbTransfCpts," . '"' . $objG . '"' . ",'','Creer','$date','',0)";
    $pdo->query($query2);

    $query3 = "INSERT INTO `agents`(`id_TCs`, `nomAgent`, `nomTuteur`, `nomResponsable`, `secteur`, `domaine`, `commentaire_A`, `commentaire_T`, `commentaire_R`) VALUES ($nbTransfCpts, " . '"' . $nomAgent . '"' . "," . '"' . $nomTuteur . '"' . ", " . '"' . $nomResponsable . '"' . ", " . '"' . $secteur . '"' . ", " . '"' . $domaine . '"' . ", '', '','')";
    $pdo->query($query3);
}


// Si il y a cloture du suivi
if (isset($_GET['cloture']) && isset($_GET['id'])) {
    $idTC = $_GET['id'];

    // On modifie son état
    $query = "UPDATE `transfert_competences` SET `etat` = 'Finalisation' WHERE `id_TCs` = $idTC";
    $pdo->query($query); ?>

    <script>
        setTimeout("showAlerte()", 2000); // Affiche le message d'alerte durant 2 sec  
    </script>
    <!-- Message d'alerte -->
    <div id="alerte" class="alert alert-success text-center" role="alert">
        Le suivi du Transfert de Compétences a bien été clotûrer
    </div>

<?php
}
// Si il y a cloture d'un bilan
elseif (isset($_GET['clotureBilan'])) { ?>

    <script>
        setTimeout("showAlerte()", 2000); // Affiche le message d'alerte durant 2 sec 
    </script>
    <!-- Message d'alerte -->
    <div id="alerte" class="alert alert-success text-center" role="alert">
        Le Transfert de Compétences a bien été clotûrer
    </div>

<?php
}
?>
<!-- Onglet de navigation -->
<div class="container d-flex justify-content-around page">

    <?php if ($role == "Responsable") { ?>
        <!-- Partie Creation -->
        <div class="boxesMenu">
            <a href="Creation/creation.php">
                <!-- <i class="bi bi-plus-square bi-10x"></i> -->
                <img src="../img/Creation_Fiche.jpg" alt="Création d'une Fiche de Transfert de Compétences">

                <h2 class="text-center">Création</h2>
            </a>
        </div>
    <?php  } ?>

    <!-- Partie Suivi -->
    <div class="boxesMenu">
        <a href="liste.php?page=Suivi">
            <!-- <i class="bi bi-pencil-square"></i> -->
            <img src="../img/suivi.png" alt="Suivi des Fiches de Transferts de Compétences">

            <h2 class="text-center">Suivi</h2>
        </a>
    </div>

    <!-- Partie Bilan -->
    <div class="boxesMenu">
        <a href="liste.php?page=Bilan">
            <!-- <i class="bi bi-check-square"></i> -->
            <img src="../img/Finalisation.png" alt="Finalisation d'une des Fiches de Transfert de Compétences">

            <h2 class="text-center">Bilan</h2>
        </a>
    </div>

    <!-- Partie Historique -->
    <div class="boxesMenu">
        <a href="liste.php?page=Historique">
            <!-- <i class="bi bi-journal-text"></i> -->
            <img src="../img/Historique.jpg" alt="Historique des Fiches de Transfert de Compétences">

            <h2 class="text-center">Historique</h2>
        </a>
    </div>
</div>

</body>

</html>