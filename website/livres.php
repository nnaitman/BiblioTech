<?php

	/*On inclut le header, le fichier de fonction d'affichage resultat PHP
	et la ressource de connexion */
	
	include('headers.php');
	include "include/fonctions_postgresql.inc.php";
	include "connexion_bd/dbconnect.php";
?>

<article>
		 
		<div>
			<?php

			/*On selectionne le titre, maison d'édition, année d'édition, résumé nom et prénom de l'auteur*/

				echo selectQuery_HTMLTable("SELECT titre,
												   maison_edition,
												   annee_edition, 	
												   resume, 
												   nom_a, prenom_a
											FROM auteur au, documents d, ecrit e, livre l
											WHERE au.id_auteur=e.id_auteur AND d.id_doc = e.id_doc AND d.id_doc = l.id_livre;");
			?>						
		</div>		
</article> 

<?php	
	require_once"include/footer.php";
?>



 
 


























