<?php
require('inc/connexion-db.php');

// Convertie une date FR prise en argument en date EN
function dateFR2EN($date){
    $listeChampsDate = explode("/", $date);
    $dateAnglais = $listeChampsDate[2]."/".$listeChampsDate[1]."/".$listeChampsDate[0];
    return $dateAnglais;
}

// Convertie une date EN prise en argument en date FR
function dateEN2FR($date){
    $listeChampsDate = explode("-", $date);
    $dateFrancaise = $listeChampsDate[2]."/".$listeChampsDate[1]."/".$listeChampsDate[0];
    return $dateFrancaise;
}

// Récupère le nombre de transfert de compétences 
function getNbTransfCpts()
{
    global $pdo;
    $query = 'SELECT COUNT(*) + 1 FROM `transfert_competences`';
    $prep = $pdo->prepare($query);
    $prep->execute();
    return $prep->fetchColumn();
}

// Nous affiche la liste selon l'etat du transfert et selon le rôle de la personne connecter 
// etat => Creer, pour la liste des Suivis ; 
// etat => Finalisation, pour la liste des Bilans ; 
// etat => Creer, pour la liste des Historiques ; 
function getListe($etat, $nom, $role)
{
   global $pdo;
    if ($role == 'Agent'){
        $query = "SELECT `transfert_competences`.`id_TCs`, agents.nomAgent, agents.nomTuteur, agents.secteur, `transfert_competences`.`objectif_global`,`transfert_competences`.`pourcentageGlobal`, `transfert_competences`.`date_creation` FROM `transfert_competences`, agents WHERE transfert_competences.etat = :etat AND `transfert_competences`.`id_TCs` = agents.id_TCs AND (agents.nomTuteur LIKE '%$nom%' OR agents.nomAgent = :nom) ORDER BY `transfert_competences`.date_creation DESC";
    }
    elseif($role == 'Responsable'){
        $query = "SELECT `transfert_competences`.`id_TCs`, agents.nomAgent, agents.nomTuteur, agents.secteur, `transfert_competences`.`objectif_global`,`transfert_competences`.`pourcentageGlobal`, `transfert_competences`.`date_creation` FROM `transfert_competences`, agents WHERE transfert_competences.etat = :etat AND `transfert_competences`.`id_TCs` = agents.id_TCs ORDER BY `transfert_competences`.date_creation DESC";
    }
    $prep = $pdo->prepare($query);
    if($role != "Responsable"){
        $prep->bindValue(':nom', $nom, PDO::PARAM_STR);
    }
    
    $prep->bindValue(':etat', $etat, PDO::PARAM_STR);
    $prep->execute();
   

    return $prep->fetchAll();
}

// Nous affiche la liste selon l'etat du transfert
// etat => Creer, pour la liste des Suivis ; 
// etat => Finalisation, pour la liste des Bilans ; 
// etat => Creer, pour la liste des Historiques ; 
// Cette fonction est disponible qu'aux Responsables 
function recherche($etat, $nomAgent, $nomTuteur, $nomResponsable, $secteur, $domaine, $dateDu, $dateAu)
{
    global $pdo;
    $query = "SELECT `transfert_competences`.`id_TCs`, agents.nomAgent, agents.nomTuteur, agents.secteur, `transfert_competences`.`objectif_global`,`transfert_competences`.`pourcentageGlobal`, `transfert_competences`.`date_creation` 
    FROM `transfert_competences`, agents 
    WHERE transfert_competences.etat = :etat 
    AND `transfert_competences`.`id_TCs` = agents.id_TCs 
    AND (
        agents.nomAgent LIKE '%$nomAgent%'
        AND  agents.nomTuteur LIKE '%$nomTuteur%' 
        AND agents.nomResponsable  LIKE '%$nomResponsable%'
        AND agents.secteur  LIKE '%$secteur%'
        AND agents.domaine  LIKE '%$domaine%'
        AND (`transfert_competences`.`date_creation` BETWEEN :dateDu AND :dateAu)
        
    )
    ORDER BY `transfert_competences`.`date_creation` DESC";
   
    $prep = $pdo->prepare($query);
    $prep->bindValue(':etat', $etat, PDO::PARAM_STR);
    $prep->bindValue(':dateDu', $dateDu, PDO::PARAM_STR);
    $prep->bindValue(':dateAu', $dateAu, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetchAll();
}

// Récupère l'ensemble des compétences
function getSuivi($idTC)
{
    global $pdo;
    $query = "SELECT * FROM `competences` WHERE id_TCs = :idTC";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':idTC', $idTC, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetchAll();
}

// Supprime l'ensemble des compétences d'un suivi
// Cette fonction vide les compétence d'un suivi qu'on remplira avec les différentes informations sur la page 
// Probleme du au tableau fais en Javascript  
function delSuivi($idTC)
{
    global $pdo;
    $query = "DELETE FROM `competences` WHERE `id_TCs`=:idTC";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':idTC', $idTC, PDO::PARAM_INT);
    $prep->execute();
}

// Recupère les informations utile afin da faire le bilan d'un transfert de compétences 
function getBilan($idTC)
{
    global $pdo;
    $query = "SELECT transfert_competences.choix_validation, agents.commentaire_A, agents.commentaire_T, agents.commentaire_R FROM `transfert_competences`, agents WHERE transfert_competences.`id_TCs`= :idTC AND transfert_competences.id_TCs = agents.id_TCs";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':idTC', $idTC, PDO::PARAM_INT);
    $prep->execute();
    return $prep->fetchAll();
}

// Récupère le nom de connexion et le compare a la BDD afin de donner un rôle à la personne connecter
function getRole($nomPrenomIntranet)
{
    global $pdo;
    $query = "SELECT `role` FROM `role` WHERE `nom_prenom` = :nomPrenom";
    $prep = $pdo->prepare($query);
    $prep->bindValue(':nomPrenom', $nomPrenomIntranet, PDO::PARAM_STR);
    $prep->execute();
    return $prep->fetchAll();
}

// Récupère l'ensemble des noms Agent + Responsable afin d'être utiliser pour les liste déroulante
function getNomAgent()
{
    global $pdo;
    $query = "SELECT `nom_prenom` FROM `role` ORDER BY `nom_prenom` ASC";
    $prep = $pdo->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

// Récupère l'ensemble des noms Responsables afin d'être utiliser pour les liste déroulante Responsable
function getNomResponsable()
{
    global $pdo;
    $query = "SELECT `nom_prenom` FROM `role` WHERE `role` = 'Responsable' ORDER BY `nom_prenom` ASC";
    $prep = $pdo->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}

// Convertie un DEJARDIN Benjamin en B.DEJARDIN
function getP_Nom($nom)
{
    $tabNom = explode(' ', $nom);
    if(count($tabNom) == 2){
        return $tabNom[1][0].".".$tabNom[0];
    }
    return $tabNom[1][0].".".$tabNom[0].' / '.$tabNom[4][0].".".$tabNom[3];
}

// Récupère l'ensemble des services, utilisé pour les listes déroulantes
function getServices()
{
    global $pdo;
    $query = "SELECT `nom_service` FROM `services`";
    $prep = $pdo->prepare($query);
    $prep->execute();
    return $prep->fetchAll();
}
?>