<?php
$nomPage = "Visualisation " . $_GET['page'];
$nbSaut = 1;
require('header.php');

$idTC = $_GET['id'];

$suivis = getSuivi($idTC);
$bilans = getBilan($idTC);

?>


    <div class="container page">

        <!-- Partie Visualisation -->
        <h5 class="card-title">Suivi : </h5>
        <div class="table-responsive marge-haut1">
            <table class="table ttable-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Date Début</th>
                        <th scope="col">Objectif</th>
                        <th scope="col">Date Fin</th>
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

            <h5 class="card-title marge-haut">Décision Finale : </h5>
            <div class="form-check form-check-inline marge-haut">
                <input class="form-check-input" type="radio" name="decisionFinal" id="nonAtteint" value="Non Atteint"
                    <?php if ($bilans[0]->choix_validation == "Non Atteint"){
                        echo "checked";} else{ echo"disabled"; }?>>
                <label class="form-check-label" for="nonAtteint">Non Atteint</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="decisionFinal" id="partiellementAtteint"
                    value="Partiellement Atteint" <?php if ($bilans[0]->choix_validation == "Partiellement Atteint"){
                        echo "checked";} else{ echo"disabled"; }?>>
                <label class="form-check-label" for="partiellementAtteint">Partiellement Atteint</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="decisionFinal" id="atteint" value="Atteint" <?php if ($bilans[0]->choix_validation == "Atteint"){
                    echo "checked";} else{ echo"disabled"; }?>>
                <label class="form-check-label" for="atteint">Atteint</label>
            </div>


            <div class="row g-3 marge-haut1">

                <div class="col-md">
                    <div class="form-floating">
                        <textarea readonly="readonly" class="form-control textarea" id="commentaireAgent" style="height: 150px"><?= $bilans[0]->commentaire_A ?></textarea>
                        <label for="commentaireAgent">Commentaire Agent</label>
                    </div>
                </div>

                <div class="col-md">
                    <div class="form-floating">
                        <textarea readonly="readonly" class="form-control textarea" id="commentaireTuteur"
                            style="height: 150px"><?= $bilans[0]->commentaire_T ?></textarea>
                        <label for="commentaireTuteur">Commentaire Tuteur</label>
                    </div>
                </div>

            </div>

            <div class="row g-3 marge-haut1">

                <div class="col-md">
                    <div class="form-floating">
                        <textarea readonly="readonly" class="form-control textarea" id="commentaireResponsable"
                            style="height: 150px"><?= $bilans[0]->commentaire_R ?></textarea>
                        <label for="commentaireResponsable">Commentaire Responsable</label>
                    </div>
                </div>

            </div>

            <!-- Bouton de navigation -->
            <div class="marge-haut">
                <a class="btn btn-primary" href="liste.php?page=<?= $_GET['page']; ?>" ><i
                        class="bi bi-arrow-bar-left"></i>
                    Liste</a>
            </div>
        </div>
</body>

</html>