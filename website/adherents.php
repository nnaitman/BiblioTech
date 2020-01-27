<?php
	
	include ('headers.php');
	include "include/fonctions_postgresql.inc.php";
	include "connexion_bd/dbconnect.php";
?>

<article>
		 
		<div style="padding:1%;">

			<?php
			//On sélectionne les informations relatives à nos adhérents 
				echo selectQuery_HTMLTable("SELECT 
											login AS Login, 
											nom AS Nom, 
											prenom AS Prénom,
											email AS Email, 
											tel AS Téléphone
											FROM adherent;");
			?>						
		</div>		
</article> 

<?php	
	require_once"include/footer.php";
?>

 
 


























