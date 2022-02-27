<?php
$nomPage = "Visualisation Suivi";
$nbSaut = 2;
require('../header.php');

$idTC = $_GET['id'];
$suivis = getSuivi($idTC);

?>

<!-- Visualisation d'un suivi -->
<div class="container page">
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
                        <td class="date">
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

        <!-- Bouton de navigation -->
        <div class="marge-haut">
            <a class="btn btn-primary" href="../liste.php?page=Suivi" role="button"><i class="bi bi-arrow-bar-left"></i>
                Liste</a>
        </div>

    </div>
</div>
</body>

</html>