<?php
$nomPage = "Création d'une Fiche";
$nbSaut = 2;
require('../header.php');

$tabNomAgent = getNomAgent();
$services = getServices();
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

<!-- Formulaire de Création -->
<div class="container page">
    <form action="../index.php" method="POST">
        <div class="row g-2">
            <div class="col-md">
                <div class="form-floating">
                    <select class="form-select select" name="nomAgent" aria-label="Nom Agent" required>
                        <option value=""></option>
                        <?php foreach ($tabNomAgent as $nom) : ?>
                            <option value="<?= $nom->nom_prenom ?>"><?= $nom->nom_prenom ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="nomAgent">Nom Agent</label>
                </div>
            </div>


        </div>

        <div class="row g-2">

            <div class="col-md">
                <div id="tuteur" class="d-flex justify-content-start form-floating">
                        <select id="nomTuteur" class="form-select select" name="nomTuteur" aria-describedby="basic-addon2" required>
                            <option id="choixTuteur" value=""></option>
                            <?php foreach ($tabNomAgent as $nom) : ?>
                                <option value="<?= $nom->nom_prenom ?>"><?= $nom->nom_prenom ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label id ='labelTuteur' for="nomTuteur">Nom Tuteur</label>

                    <div id="bouton" class="input-group-append">
                        <span class="input-group-text" id="basic-addon2" style="height:58px"><button type="button" class="btn btn-outline-primary" onclick="addTuteur()">+</button></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <input type="text" class="form-control" name="domaine" placeholder="" value="" required>
                    <label for="domaine">Domaines d'activités</label>
                </div>
            </div>

            <div class="col-md">
                <div class="form-floating">
                    <select id="Service" class="form-select select" name="secteur" aria-label="Service" aria-describedby="basic-addon3" required>
                        <option value=""></option>
                        <?php foreach ($services as $service) : ?>
                            <option value="<?= $service->nom_service ?>"><?= $service->nom_service ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="Service">Service</label>
                </div>
            </div>
        </div>

        <div class="row g-2">

            <div class="col-md">
                <div class="form-floating">
                    <textarea class="form-control" name="ObjectifG" style="height: 150px" required></textarea>
                    <label for="ObjectifG">Objectif Global</label>
                </div>
            </div>

        </div>

        <!-- Tableau de Compétence a valider -->

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="tableau">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">Date Début</th>
                        <th scope="col" class="text-center">Objectif</th>
                        <th scope="col" class="text-center">Date Fin</th>
                        <th scope="col" class="text-center"></th>
                    </tr>
                </thead>
                <tbody id="kids">

                    <tr class="ligne0">
                        <td class="date">
                            <input type="text" class="form-control datepicker text-center" name="dateDeb[0]" placeholder="" value="" required>
                        </td>
                        <td>
                            <textarea class="form-control" name="Objectif[0]" required></textarea>
                        </td>
                        <td class="date text-end">
                            <input type="text" class="form-control datepicker text-center" name="dateFin[0]" placeholder="" value="" required>
                        </td>

                        <td class="text-end delete">
                            <button type="button" onclick="del(this.parentNode, 1)" class="btn btn-outline-primary"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" onclick="addKid(1)" class="btn btn-outline-primary ajoutLigne">Ajouter une ligne</button>

            <hr>

            <!-- Bouton de direction -->

            <div class="marge-haut">
                <a class="btn btn-primary" href="../index.php" role="button"><i class="bi bi-arrow-bar-left"></i> Menu</a>
                <input class="btn btn-primary float-end" type="submit" name="Creation" value="Créer la fiche de transfert">
            </div>

        </div>
    </form>
</div>
</body>

</html>