<?php
$nomPage = "Bilan";
$nbSaut = 2;
require('../header.php');
$idTC = $_GET['id'];
$suivis = getSuivi($idTC);

session_start();

if($_SESSION['isTuteur'][$idTC] && $role != "Responsable"){
    $role = "Tuteur";
}

if (isset($_POST['Finalisation'])) {
    $choix = $_POST['decisionFinal'];
    $commentaire = $_POST['commentaire'];


    if ($role == "Agent") {
        $query = "UPDATE `transfert_competences`, agents SET agents.commentaire_A = " . '"' . $commentaire . '"' . " WHERE transfert_competences.`id_TCs`= $idTC AND transfert_competences.id_TCs = agents.id_TCs";
        // echo $query;
    } elseif ($role == "Tuteur") {
        $query = "UPDATE `transfert_competences`, agents SET transfert_competences.choix_validation = '$choix', agents.commentaire_T = " . '"' . $commentaire . '"' . " WHERE transfert_competences.`id_TCs`= $idTC AND transfert_competences.id_TCs = agents.id_TCs";
    } elseif ($role == "Responsable") {
        $commentaireA = $_POST['commentaireAgent'];
        $commentaireT = $_POST['commentaireTuteur'];
        $query = "UPDATE `transfert_competences`, agents SET transfert_competences.choix_validation = '$choix', agents.commentaire_R = " . '"' . $commentaire . '"' . " WHERE transfert_competences.`id_TCs`= $idTC AND transfert_competences.id_TCs = agents.id_TCs";
        $pdo->query($query);
        $query = "UPDATE `transfert_competences`, agents SET agents.commentaire_A = " . '"' . $commentaireA . '"' . " WHERE transfert_competences.`id_TCs`= $idTC AND transfert_competences.id_TCs = agents.id_TCs";
        $pdo->query($query);
        $query = "UPDATE `transfert_competences`, agents SET transfert_competences.choix_validation = '$choix', agents.commentaire_T = " . '"' . $commentaireT . '"' . " WHERE transfert_competences.`id_TCs`= $idTC AND transfert_competences.id_TCs = agents.id_TCs";
       
    } 
    $pdo->query($query);
?>

    <script>
        setTimeout("showAlerte()", 1500);
    </script>
    <div id="alerte" class="alert alert-success text-center" role="alert">
        La modification a bien été faite.
    </div>

<?php
}

$bilans = getBilan($idTC);

// var_dump($bilans);
?>

<!-- Visualisation d'un suivi -->
<div class="container page">
    <h5 class="card-title">Suivi : </h5>
    <div class="table-responsive">
        <table class="table ttable-hover align-middle">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Date Début</th>
                    <th scope="col">Objectif</th>
                    <th scope="col" class="text-center">Date Fin</th>
                    <th scope="col" class="text-center">Validation (%) </th>
                    <th scope="col">Commentaire Tuteur</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($suivis as $suivi) :
                ?>
                    <tr>
                        <td class="date">
                            <p><?= dateEN2FR($suivi->date_debut) ?></p>
                        </td>
                        <td class="colonneLongue">
                            <p><?= $suivi->objectif ?></p>
                        </td>
                        <td class="date">
                            <p><?= dateEN2FR($suivi->date_fin) ?></p>
                        </td>
                        <td class="text-center">
                            <p><?= $suivi->pourcentage . '%' ?></p>
                        </td>
                        <td class="colonneLongue">
                            <p><?= $suivi->commentaire ?></p>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>

            </tbody>
        </table>
    </div>

    <!-- Formulaire de Finalisation d'un transfert de Compétences -->
    <form method="POST">

        <input type="hidden" name="id" value="<?= $idTC ?>">


        <?php if ($role == "Responsable") { ?>
            <h5 class="card-title marge-haut">Décision Finale : </h5>
            <div class="form-check form-check-inline marge-haut">
                <input class="form-check-input" type="radio" name="decisionFinal" id="nonAtteint" value="Non Atteint" required <?php if ($bilans[0]->choix_validation == "Non Atteint") {
                                                                                                                            echo "checked";
                                                                                                                        } ?>>
                <label class="form-check-label" for="nonAtteint">Non Atteint</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="decisionFinal" id="partielementAtteint" value="Partielement Atteint" required <?php if ($bilans[0]->choix_validation == "Partielement Atteint") {
                                                                                                                                            echo "checked";
                                                                                                                                        } ?>>
                <label class="form-check-label" for="partiellementAtteint">Partiellement Atteint</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="decisionFinal" id="atteint" value="Atteint" required <?php if ($bilans[0]->choix_validation == "Atteint") {
                                                                                                                    echo "checked";
                                                                                                                } ?>>
                <label class="form-check-label" for="atteint">Atteint</label>
            </div>
        <?php } ?>

        <div class="row g-3 marge-haut1">
            <h5 class="card-title">Commentaire <?= $role ?> : </h5>
            <div class="col-md">
                <div class="form-floating">
                    <textarea class="form-control" name="commentaire" id="commentaireFinal" style="height: 150px" required><?php if ($role == "Agent") {echo $bilans[0]->commentaire_A;} elseif ($role == "Tuteur") {echo $bilans[0]->commentaire_T;} elseif ($role == "Responsable") {echo $bilans[0]->commentaire_R;} ?></textarea>
                    <label for="commentaireFinal">Commentaire <?= $role ?></label>
                </div>
            </div>
        </div>

        <div>
            <input class="btn btn-outline-primary marge-haut1" id="commentaireDefaut" type="button" onclick="defaut(1)" value="Commentaire par défaut">
            <?php if ($role == "Responsable" && $bilans[0]->commentaire_A != null && $bilans[0]->commentaire_T != null && $bilans[0]->commentaire_R != null) { ?><input class="btn btn-outline-primary marge-haut1 float-end" onclick="document.location.href = 'clotureFiche.php?clotureBilan=true&id=<?= $idTC ?>'" type="button" value="Clôturer le Transfert de Compétences"><?php } ?>
        </div>

        <?php if ($role == "Responsable") { ?>
            <h5 class="card-title marge-haut1">Autres Commentaires : </h5>
            <div class="row g-3 marge-haut1 d-flex justify-content-start">
                <div class="col-md">
                    <div class="form-floating">
                        <textarea class="form-control" name="commentaireAgent" id="commentaireA" style="height: 150px"><?= $bilans[0]->commentaire_A;?></textarea>
                        <label for="commentaireA">Commentaire Agent</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <textarea class="form-control" name="commentaireTuteur" id="commentaireT" style="height: 150px"><?= $bilans[0]->commentaire_T; ?></textarea>
                        <label for="commentaireT">Commentaire Tuteur</label>
                    </div>
                </div>
            </div>

            <div>
                <input class="btn btn-outline-primary marge-haut1" id="commentaireDefaut2" type="button" onclick="defaut(2)" value="Commentaire par défaut">
                <input class="btn btn-outline-primary marge-haut1 float-end" id="commentaireDefaut3" type="button" onclick="defaut(3)" value="Commentaire par défaut">
            </div>

        <?php } ?>

        <div class="marge-haut">
            <a class="btn btn-primary" href="../liste.php?page=Bilan" role="button"><i class="bi bi-arrow-bar-left"></i> Liste</a>
            <input class="btn btn-primary float-end" type="submit" name="Finalisation" value="Valider">
        </div>
    </form>
</div>

</body>

</html>