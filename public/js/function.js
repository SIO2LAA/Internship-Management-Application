    // Récupérer l'id
function id(id) {
    return document.getElementById(id);
}

function clas(clas) {
    return document.getElementsByClassName(clas);
}


id("imgcompte").addEventListener("click", ShowCompte);


    //Afficher et Fermer Compte
function ShowCompte() {
    if (id("connex").style.display != 'block') {
        id("connex").style.display = 'block';
    } else {
        id("connex").style.display = 'none';
    }
}

function confirmSuppr() {
	if (confirm("Attention ! Voulez vous vraiment supprimer cet élément ?") == false) {
		event.preventDefault();
	}
}