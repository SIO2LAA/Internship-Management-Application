$(function(){
	// On recupere la position du bloc par rapport au haut du site
	var position_top_raccourci = $("#container-menu").offset().top;

	//Au scroll dans la fenetre on déclenche la fonction
	$(window).scroll(function () {

		//si on a defile de plus de 150px du haut vers le bas
		if ($(this).scrollTop() > position_top_raccourci) {

			//on ajoute la classe "menufixe" a <nav id="container-menu">
			$('#container-menu').addClass("menufixe");
			$('#connex').addClass("connexfixe");
			document.getElementById("principal").className = "principalfixe";
		} else {

			//sinon on retire la classe "menufixe" a <nav id="container-menu">
			$('#container-menu').removeClass("menufixe");
			$('#connex').removeClass("connexfixe");
			document.getElementById("principal").className = "";
		}
	});
});
