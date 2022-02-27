<?php
$nomPage = "Clôture Fiche";
$nbSaut = 2;
require('../header.php');
$idTC = $_GET['id'];

if (isset($_POST['Cloture'])) {
    $satisfaction = $_POST['satisfaction'];
    $majTabCpts = $_POST['majTabCpts'];
    if ($majTabCpts == "Oui") {
        $query = "UPDATE `transfert_competences` SET `satisfaction` = '$satisfaction', `etat` = 'Fermer' WHERE `id_TCs` = $idTC";
        $pdo->query($query); ?>
        <script>
            location.href = "../index.php?clotureBilan=true";
        </script>
    <?php
    } ?>

    <div id="alerte" class="alert alert-danger text-center" role="alert">
        Veuillez mettre à jour le tableau de compétences
    </div>
<?php
}
?>
<div class="container page">
    <form method="POST">

        <input type="hidden" name="id" value="<?= $idTC ?>">


        <h5 class="card-title marge-haut">Satisfaction de l’évalué sur 10 : </h5>
      

        <div class="btn-group marge-haut1">
            <button type="button" id="bouton1" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(1)">1</button>
            <button type="button" id="bouton2" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(2)">2</button>
            <button type="button" id="bouton3" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(3)">3</button>
            <button type="button" id="bouton4" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(4)">4</button>
            <button type="button" id="bouton5" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(5)">5</button>
            <button type="button" id="bouton6" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(6)">6</button>
            <button type="button" id="bouton7" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(7)">7</button>
            <button type="button" id="bouton8" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(8)">8</button>
            <button type="button" id="bouton9" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(9)">9</button>
            <button type="button" id="bouton10" class="btn btn-outline-primary boutonSatisfactions" onclick="satisfaction123(10)">10</button>
        </div>

        <div id="satisfaction">
            <input type="hidden" name="satisfaction" value="">
        </div>
        
        <h5 class="card-title marge-haut">Avez-vous mis à jour le tableau de compétences ?</h5>
        <div class="form-check form-check-inline marge-haut">
            <input class="form-check-input" type="radio" name="majTabCpts" id="Non" value="Non">
            <label class="form-check-label" for="Non">Non</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="majTabCpts" id="Oui" value="Oui">
            <label class="form-check-label" for="Oui">Oui</label>
        </div>


        <div class="marge-haut">
            <a class="btn btn-primary" href="Bilan.php?id=<?= $idTC ?>" role="button"><i class="bi bi-arrow-bar-left"></i> Bilan</a>
            <input class="btn btn-primary float-end" type="submit" name="Cloture" value="Valider">
        </div>

    </form>
</div>