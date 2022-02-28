<?php
$nomPage = "Liste " . $_GET['page']; // Correspond au titre de la page
$nbSaut = 1; // Correspond au nombre de saut a faire pour aller jusqu'a la racine du projet
require('header.php');

$listeAgents = getNomAgent(); // Liste avec l'ensemble des Agent pour liste déroulante dans la recherche
$listeServices = getServices(); // Liste avec l'ensemble des Services pour liste déroulante dans la recherche
$listeResponsable = getNomResponsable();

if (isset($_POST['Recherche'])) {

    $nomAgent = $_POST['nomAgent'];
    if ($role == "Agent") {
        $nomAgent = $nomPrenomUser;
    }

    $nomTuteur = $_POST['nomTuteur'];

    $nomResponsable = $_POST['nomResponsable'];

    $secteur = $_POST['secteur'];
    $domaine = $_POST['domaine'];


    if ($_POST['dateDu'] == null) {
        $dateDu = "2000-01-01";
    } else {
        $dateDu = $_POST['dateDu'];
        $dateDu = dateFR2EN($dateDu);
    }

    if ($_POST['dateAu'] == null) {
        $dateAu = date("Y-m-d");
    } else {
        $dateAu = $_POST['dateAu'];
        $dateAu = dateFR2EN($dateAu);
    }
}

if ($_GET['page'] == "Suivi") {
    if (isset($_POST['Recherche'])) {

        if (!empty($_POST['nomAgent']) || !empty($_POST['nomTuteur']) || !empty($_POST['nomResponsable']) || !empty($_POST['secteur']) || !empty($_POST['domaine']) || !empty($_POST['dateDu']) || !empty($_POST['dateAu'])) {
            $listes = recherche('Creer', $nomAgent, $nomTuteur, $nomResponsable, $secteur, $domaine, $dateDu, $dateAu);
        } else {
            $listes = getListe('Creer', $nomPrenomUser, $role);
        }
    } else {
        $listes = getListe('Creer', $nomPrenomUser, $role);
        // print_r(getListe('Creer'));
    }
} elseif ($_GET['page'] == "Bilan") {
    if (isset($_POST['Recherche'])) {

        if (!empty($_POST['nomAgent']) || !empty($_POST['nomTuteur']) || !empty($_POST['nomResponsable']) || !empty($_POST['secteur']) || !empty($_POST['dateDu']) || !empty($_POST['dateAu'])) {
            $listes = recherche('Finalisation', $nomAgent, $nomTuteur, $nomResponsable, $secteur, $domaine, $dateDu, $dateAu);
        } else {
            // $listes = getListe('Finalisation', $nomPrenomUser, $role);
        }
    } else {
        $listes = getListe('Finalisation', $nomPrenomUser, $role);
    }
} elseif ($_GET['page'] == "Historique") {
    if (isset($_POST['Recherche'])) {

        if (!empty($_POST['nomAgent']) || !empty($_POST['nomTuteur']) || !empty($_POST['nomResponsable']) || !empty($_POST['secteur']) || !empty($_POST['dateDu']) || !empty($_POST['dateAu'])) {
            $listes = recherche('Fermer', $nomAgent, $nomTuteur, $nomResponsable, $secteur, $domaine, $dateDu, $dateAu);
        } else {
            $listes = getListe('Fermer', $nomPrenomUser, $role);
        }
    } else {
        $listes = getListe('Fermer', $nomPrenomUser, $role);
    }
}

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

<div class="container page">


    <!-- Bouton de navigation -->
    <div class="d-flex justify-content-between">
        <a class="btn btn-outline-primary" href="index.php" role="button"><i class="bi bi-arrow-bar-left"></i> Menu</a>

        <?php if ($role == "Responsable") : ?>
            <button class="btn btn-outline-primary boutonRecherche" id="afficheRecherche">
                <i id="icone" class="bi bi-chevron-expand"></i> Recherche
            </button>
        <?php endif; ?>
    </div>

    <?php if ($role == "Responsable") : ?>
        <!-- Contenu Recherche -->
        <div id="recherche">
            <form action="liste.php?page=<?= $_GET['page'] ?>" method="POST">
                <div class="row g-2">

                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select select" name="nomAgent" aria-label="Nom Agent">
                                <option value=""></option>
                                <?php foreach ($listeAgents as $nom) : ?>
                                    <option value="<?= $nom->nom_prenom ?>"><?= $nom->nom_prenom ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="nomAgent">Nom Agent</label>
                        </div>
                    </div>

                </div>

                <div class="row g-2">

                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select select" name="nomResponsable" aria-label="Nom Responsable">
                                <option value=""></option>
                                <?php foreach ($listeResponsable as $nom) : ?>
                                    <option value="<?= $nom->nom_prenom ?>"><?= $nom->nom_prenom ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="nomResponsable">Nom Responsable</label>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-floating">
                            <select class="form-select select" name="nomTuteur" aria-label="Nom Tuteur">
                                <option value=""></option>
                                <?php foreach ($listeAgents as $nom) : ?>
                                    <option value="<?= $nom->nom_prenom ?>"><?= $nom->nom_prenom ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="nomTuteur">Nom Tuteur</label>
                        </div>
                    </div>

                </div>

                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            <select id="Service" class="form-select select" name="secteur" aria-label="Service" aria-describedby="basic-addon3">
                                <option value=""></option>
                                <?php foreach ($listeServices as $service) : ?>
                                    <option value="<?= $service->nom_service ?>"><?= $service->nom_service ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="Service">Service</label>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="domaine" placeholder="" value="">
                            <label for="nomDomaine">Nom Domaine</label>
                        </div>
                    </div>
                </div>


                <div class="row g-2">

                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" name="dateDu" class="form-control datepicker" placeholder="" value="">
                            <label for="dateDeb">Du : </label>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form-floating">
                            <input type="text" name="dateAu" class="form-control datepicker" placeholder="" value="">
                            <label for="dateFin">Au :</label>
                        </div>
                    </div>

                </div>
                <div class="row g-2">

                    <div class="col-md">
                        <div class="form-floating">
                            <div class="col-12">
                                <button class="btn btn-outline-primary" name="Recherche" value="OK" type="submit">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Tableau d'Agent avec Fiche terminé -->

    <div class="table-responsive marge-haut">
        <table class="table ttable-hover align-middle">
            <thead>
                <tr>
                    <th scope="col" class="text-start">Nom Agent</th>
                    <th scope="col" class="text-start">Nom(s) Tuteur(s)</th>
                    <th scope="col" class="text-start">Service</th>
                    <th scope="col" class="text-start">Objectif Global</th>
                    <th scope="col" class="text-start">% Global</th>
                    <th scope="col" class="text-start"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listes as $element) : ?>
                    <tr class="lignes-liste">
                        <?php
                        $nomTuteurs =  explode(' / ', $element->nomTuteur);

                        if (in_array($nomPrenomUser, $nomTuteurs)) {
                            $_SESSION['isTuteur'][$element->id_TCs] = true;
                        } else {
                            $_SESSION['isTuteur'][$element->id_TCs] = false;
                        }
                        ?>
                        <td><?php if ($_GET['page'] != "Historique" && ($role != "Agent" || $_GET['page'] != "Suivi" || $_SESSION['isTuteur'][$element->id_TCs])) : ?><a class="liens-liste" href="<?= $_GET['page'] . "/" . $_GET['page'] . ".php?id=" . $element->id_TCs; ?>"><?php endif;
                                                                                                                                                                                                                                                                            echo getP_Nom($element->nomAgent); ?></a></td>
                        <td><?php if ($_GET['page'] != "Historique" && ($role != "Agent" || $_GET['page'] != "Suivi" || $_SESSION['isTuteur'][$element->id_TCs])) : ?><a class="liens-liste" href="<?= $_GET['page'] . "/" . $_GET['page'] . ".php?id=" . $element->id_TCs; ?>"><?php endif;
                                                                                                                                                                                                                                                                            echo getP_Nom($element->nomTuteur); ?></a></td>
                        <td><?php if ($_GET['page'] != "Historique" && ($role != "Agent" || $_GET['page'] != "Suivi" || $_SESSION['isTuteur'][$element->id_TCs])) : ?><a class="liens-liste" href="<?= $_GET['page'] . "/" . $_GET['page'] . ".php?id=" . $element->id_TCs; ?>"><?php endif;
                                                                                                                                                                                                                                                                            echo $element->secteur; ?></a></td>
                        <td><?php if ($_GET['page'] != "Historique" && ($role != "Agent" || $_GET['page'] != "Suivi" || $_SESSION['isTuteur'][$element->id_TCs])) : ?><a class="liens-liste" href="<?= $_GET['page'] . "/" . $_GET['page'] . ".php?id=" . $element->id_TCs; ?>"><?php endif;
                                                                                                                                                                                                                                                                            echo $element->objectif_global; ?></a></td>
                        <td><?php if ($_GET['page'] != "Historique" && ($role != "Agent" || $_GET['page'] != "Suivi" || $_SESSION['isTuteur'][$element->id_TCs])) : ?><a class="liens-liste" href="<?= $_GET['page'] . "/" . $_GET['page'] . ".php?id=" . $element->id_TCs; ?>"><?php endif;
                                                                                                                                                                                                                                                                            echo $element->pourcentageGlobal . " %"; ?></a></td>
                        <?php if ($_GET['page'] == "Suivi") :  ?><td><a class="visualisation text-center" href="<?= $_GET['page'] . "/visualisation" . $_GET['page'] . ".php?id=" . $element->id_TCs; ?>"><i class="bi bi-eye"></i></a></td>
                        <?php else :  ?> <td><a class="visualisation text-center" href="<?= "visualisation.php?id=" . $element->id_TCs . "&page=" . $_GET['page']; ?>"><i class="bi bi-eye"></i></a></td><?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>


    <!-- Script pour Afficher/Retirer la recherche + Changer l'icone -->
    <script>
        let togg1 = document.getElementById("afficheRecherche");
        let d1 = document.getElementById("recherche");
        togg1.onclick = togg;
    </script>


    </body>

    </html>