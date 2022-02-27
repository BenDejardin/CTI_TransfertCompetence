// Script pour Afficher/Retirer la recherche + Changer l'icone 
function togg() {
    if (getComputedStyle(d1).display != "none") {
        d1.style.display = "none";
        document.getElementById("icone").className = 'bi bi-chevron-expand';
    } else {
        d1.style.display = "block";
        document.getElementById("icone").className = 'bi bi-chevron-contract';
    }
};

// Script pour Commentaire par défaut
function defaut(type) {
    if(type == 1 ){ let cf = document.getElementById("commentaireFinal"); cf.value = "Vu et approuvé."; }
    if(type == 2 ){ let cf2 = document.getElementById("commentaireA"); cf2.value = "Vu et approuvé."; }
    if(type == 3 ){ let cf3 = document.getElementById("commentaireT"); cf3.value = "Vu et approuvé."; }
};


// Script pour ajouter une ligne au tableau 
var i = 1;

function addKid(type) {

    var a = document.getElementsByTagName('tr').length - 1;
    var nouvelleLigne = document.createElement('tr');


    if (type == 1) {
        nouvelleLigne.innerHTML = '<td class="date"><input type="text" class="form-control datepicker" name="dateDeb[' + i + ']" placeholder="" value="" required></td><td><textarea class="form-control" name="Objectif[' + i + ']"></textarea></td><td class="date text-end"><input type="text" class="form-control datepicker" name="dateFin[' + i + ']" placeholder="" value="" required></td><td class="text-end delete"><button type="button" onclick="del(this.parentNode, 1)" class="btn btn-outline-primary"><i class="bi bi-trash"></i></button></td>';
        i++;
    }

    if (type == 2) {
        nouvelleLigne.innerHTML = '<td class="date"><input type="text" class="form-control datepicker" name="dateDeb[' + a + ']" placeholder="" value="" required></td><td><textarea class="form-control" name="Objectif[' + a + ']"></textarea></td><td class="date"><input type="text" class="form-control datepicker" name="dateFin[' + a + ']" placeholder="" value="" required></td><td class="date"><input type="text" class="form-control" name="pourcentage[' + a + ']" placeholder="" value="0" required></td><td><textarea class="form-control" name="Commentaire[' + a + ']"></textarea></td><td class="text-end delete"><button type="button" onclick="del(this.parentNode , 2)" class="btn btn-outline-primary"><i class="bi bi-trash"></i></button></td>';
        a++;
    }

    document.getElementById('kids').appendChild(nouvelleLigne);


    // console.log("add : i = " + i);

    // Script Date Calendrier
    $(document).ready(function () {
        ! function (a) {
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

}

// // Script pour supprimer une ligne 
function del(element, type) {
    document.getElementById('kids').removeChild(element.parentNode);
    if (type == 1) {
        i--;
    }
    if (type == 2) {
        a--;
    }
}

// Script pour les pop up 
function showAlerte() {
    document.getElementById("alerte").style.display = "none";
}

let ligne;

//Script pour ajouter un tuteur
function addTuteur() {
    const divTuteur = document.getElementById("tuteur");
    const divBouton = document.getElementById("bouton");
    const selectValue = document.getElementById("nomTuteur").value;

    let select1 = document.getElementById("nomTuteur");
    
    let option = document.getElementById("choixTuteur");
    option.innerHTML="";
    option.innerHTML+=selectValue;
    option.value = selectValue;
    
    select1.parentElement.removeChild(divBouton);

    ligne = select1.parentElement.innerHTML;

    select1.setAttribute('name', "nomTuteur[0]");
    let t = select1.parentElement.innerHTML+'&nbsp;&nbsp;';
    
    let select2 = document.getElementById("nomTuteur");
    select2.setAttribute('id','nomTuteur2');
    let option2 = document.getElementById("choixTuteur");
    option2.innerHTML="";
    select2.setAttribute('name', "nomTuteur[1]");

    divTuteur.innerHTML = t +select2.parentElement.innerHTML+'<div id="bouton" class="input-group-append"><span class="input-group-text" id="basic-addon2" style="height:58px"><button type="button" id="boutonTuteur" class="btn btn-outline-primary" onclick="delTuteur()">-</button></span></div>';

}

//Script pour retirer un tuteur
function delTuteur() {
    var divTuteur = document.getElementById("tuteur");
   
    divTuteur.innerHTML = '<div class="col-md"><div id="tuteur" class="d-flex justify-content-start form-floating">'+ligne+'<div id="bouton" class="input-group-append"><span class="input-group-text" id="basic-addon2" style="height:58px"><button type="button" class="btn btn-outline-primary" onclick="addTuteur()">+</button></span></div></div>';

}

//Script pour la satisfaction de 1 à 10
function satisfaction123(numeroSatisfaction) {
    var satisfaction = document.getElementById("satisfaction");
    satisfaction.innerHTML = '<input id="satisfaction" type="hidden" name="satisfaction" value="'+numeroSatisfaction+'" required>';

    var boutonSatisfactions = document.getElementsByClassName("boutonSatisfactions");

    for (let index = 0; index < boutonSatisfactions.length; index++) {
        boutonSatisfactions[index].style.backgroundColor = "#FFF";
        boutonSatisfactions[index].style.color = "#0d6efd";
    }
    

    var boutonSelectioner = document.getElementById("bouton"+numeroSatisfaction);
    boutonSelectioner.style.backgroundColor = "#0d6efd";
    boutonSelectioner.style.color = "#FFF";
}
