<?php
$nomPage = "Suivi";
$nbSaut = 2;
require('../header.php'); 



if ($_GET['id']) {
    $idTC = $_GET['id'];
} else {
    $idTC = $_POST['id'];
}

if (isset($_POST['Modification'])) {

    $index = 0;
    foreach ($_POST['dateDeb'] as $dateDeb) {
        $dateDeb = dateFR2EN($dateDeb);
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
    $index = 0;
    foreach ($_POST['pourcentage'] as $pourcentage) {
        $tabPourcentage[$index] = $pourcentage;
        $index++;
    }
    $index = 0;
    foreach ($_POST['Commentaire'] as $commentaire) {
        $tabCommentaire[$index] = $commentaire;
        $index++;
    }

    delSuivi($idTC);

    for ($i = 0; $i < $index; $i++) {

        $query = "INSERT INTO `competences`(`id_TCs`, `date_debut`, `objectif`, `date_fin`, `pourcentage`, `commentaire`) VALUES ($idTC, '$tabDateDeb[$i]'," . '"' . $tabObjectif[$i] . '"' . ", '$tabDateFin[$i]', $tabPourcentage[$i], " . '"' . $tabCommentaire[$i] . '"' . ")";
        // var_dump($query);
        $pdo->query($query);
    } ?>
    <script>
        setTimeout("showAlerte()", 1500);
    </script>
    <div id="alerte" class="alert alert-success text-center" role="alert">
        La modification a bien été faite.
    </div>

<?php

    $result = 0;
    $nbPourcentage = 0;
    foreach ($tabPourcentage as $pourcentage) {
        $result = $result + $pourcentage;
        $nbPourcentage++;
    }
    $pourcentageG = $result / $nbPourcentage;
    $pourcentageG = number_format($pourcentageG, 2);

    $query2 = "UPDATE `transfert_competences` SET `pourcentageGlobal`= $pourcentageG WHERE `id_TCs`= $idTC";
    $pdo->query($query2);
}


$suivis = getSuivi($idTC);


?>

<script type="text/javascript">
    // Script pour le calendier
    $(document).ready(function() {
        ! function(a) {
            a.fn.datepicker.dates.fr = {
                days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
                daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
                daysMin: ["d", "l", "ma", "me", "j", "v", "s"],
                months: ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
                monthsShort: ["janv.", "févr.", "mars", "avril", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."],
                today: "Aujourd'hui",
                monthsTitle: "Mois",
                clear: "Effacer",
                weekStart: 1,
                format: "dd/mm/yyyy",
            }
        }(jQuery);

        $('.datepicker').datepicker({
            maxViewMode: 2,
            language: 'fr',
            orientation: "bottom left",
            //daysOfWeekDisabled: "0",
            // calendarWeeks: true,
            todayHighlight: true,
            autoclose: true,
            format: "dd/mm/yyyy",

        });

    });
</script>

<!-- Formulaire de suivi -->
<div class="container page">
    <form method="POST">
        <div class="table-responsive">
            <table class="table ttable-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Date Début</th>
                        <th scope="col" class="text-center">Objectif</th>
                        <th scope="col" class="text-center">Date Fin</th>
                        <th scope="col" class="text-center">%</th>
                        <th scope="col" class="text-center">Commentaire Tuteur</th>
                        <th scope="col" class="text-center"></th>

                    </tr>
                </thead>
                <tbody id="kids">
                    <?php
                    $ligne = 0;
                    foreach ($suivis as $suivi) :
                    ?>
                        <tr>
                            <input type="hidden" name="id" value="<?= $suivi->id_TCs ?>">
                            <td class="date">
                                <input type="text" class="form-control datepicker" name="dateDeb[<?= $ligne ?>]" placeholder="" value="<?= dateEN2FR($suivi->date_debut) ?>">
                            </td>
                            <td>
                                <textarea class="form-control" name="Objectif[<?= $ligne ?>]"><?= $suivi->objectif ?></textarea>
                            </td>
                            <td class="date">
                                <input type="text" class="form-control datepicker" name="dateFin[<?= $ligne ?>]" placeholder="" value="<?= dateEN2FR($suivi->date_fin) ?>">
                            </td>
                            <td class="date">
                                <input type="text" class="form-control" name="pourcentage[<?= $ligne ?>]" placeholder="" value="<?= $suivi->pourcentage ?>">
                            </td>
                            <td>
                                <textarea class="form-control" name="Commentaire[<?= $ligne ?>]"><?= $suivi->commentaire ?></textarea>
                            </td>
                            <td class="text-end delete">
                                <button type="button" onclick="del(this.parentNode , 2)" class="btn btn-outline-primary">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php
                        $ligne++;
                    endforeach;
                    ?>
                </tbody>
            </table>

            <!-- <button type="button" onclick="addKid(2)" class="btn btn-outline-primary ajoutLigne">Ajouter une ligne</button> -->

            <div>
                <input class="btn btn-outline-primary ajoutLigne" onclick="addKid(2)" type="button" value="Ajouter une ligne">
                <input class="btn btn-outline-primary float-end" onclick="document.location.href = '../index.php?cloture=true&id=<?= $idTC ?>'" type="button" value="Clôturer le Suivi">
            </div>

            <!-- Bouton de navigation -->
            <div class="marge-haut">
                <a class="btn btn-primary" href="../liste.php?page=Suivi" role="button"><i class="bi bi-arrow-bar-left"></i> Liste</a>
                <input class="btn btn-primary float-end" type="submit" name="Modification" value="Valider">
            </div>

        </div>
    </form>
</div>
</body>

</html>