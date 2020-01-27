<?php
	
	
	include ('headers.php');
	include "include/fonctions_postgresql.inc.php";	

?>

	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="main.php">Home</a></li>
			<li class="active">Emprunter</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-sm-9 maincontent">
				<header class="page-header">
					<h1 class="page-title">Emprunter</h1>
				</header>
				
				<p>
					Vous êtes intéressé par un livre ou une revue, en particulier? Il ne vous suffit que de l'emprunter.
					Pour cela, vous devez saisir votre nom, prénom, ainsi que l'ID du livre situé au dos du livre.
				</p>
				<br>
					<form method="POST" action="#">
						<div class="row">
							<div class="col-sm-4">
								<input name="id_adherent" class="form-control" type="text" placeholder="ID Adhérent">
							</div>
							<div class="col-sm-4">
								<input name="id_exemplaire" class="form-control" type="text" placeholder="ID Livre">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6 text-right">
								<input name="sbm4" class="btn btn-action" type="submit" value="Emprunter">
							</div>
						</div>
					</form>

					<hr>

					<?php
						
						if (isset($_POST['sbm4'])) {


							include_once "connexion_bd/dbconnect.php";

							//On récupère l'iD adhérent et l'iD exemplaire saisis par le formulaire 

							$id_ad = $_POST['id_adherent'];
							$id_ex = $_POST['id_exemplaire'];

							//On vérifie d'abord la disponibilité du livre, avant de l'emprunter

							$query0 = "SELECT disponibilite
									   FROM exemplaire 
									   WHERE (code_barre_exemplaire='$id_ex');";

						   $result0 = pg_query($connexion, $query0);
						   if (!$result0){
						   		echo'<p class="msg_emprunt">Les champs sont restés vides</p>';

						   		//On affiche les erreurs SQL
						   		echo pg_last_error();
							}

							else {
								
								//On vérifie si le livre est disponible. En vérifiant si l'attribut "Disponibilité" est "false"
								$row=pg_fetch_row($result0);
        				   
								if ($row[0] == "false"){

						   			echo '<p class="msg_emprunt">Ce livre n\'est pas disponible</p>';
				   			}
					   			
					   		else {

									
									$date_debut = date("Y-m-d");
									$date_retour = date('Y-m-d', strtotime($date_debut.' +15 days'));

									//On insère le document emprunté dans la table "emprunter"
									$query1= "INSERT INTO emprunter 
									  VALUES ('$id_ex', '$id_ad','$date_retour');";	

						  			$result1= pg_query($connexion,$query1);

						  			if ($result1){
						  			echo '<p class="msg_emprunt">Vous avez bien emprunté ce livre</p>';
						  			}
						  			else {
						  				echo'<p class="msg_alert">Une erreur s\'est produite.</p>';
						  				echo pg_last_error();
						  			}

						  			pg_free_result ($result1); 


									//On change la disponibilité du document emprunté vers False
									$query2= "UPDATE exemplaire 
									  		SET disponibilite='false'
									  		WHERE exemplaire.code_barre_exemplaire IN (SELECT exemplaire.code_barre_exemplaire FROM exemplaire,emprunter,adherent 
                                          	WHERE exemplaire.code_barre_exemplaire='$id_ex' 
                                          	AND adherent.login='$id_ad');";


									$result2 = pg_query($connexion, $query2);

									if (!$result2){
						  				echo"Erreur2 SQL!";
						  				echo pg_last_error();
					  				}
					  				
					  				else {
					  					if($result1){

					  						echo'<p class="msg_emprunt">Bonne lecture!</p>';
					  						  				
											//On affiche le titre relatif au document emprunté
										
											echo'<p class="msg_emprunt">Bonne lecture!</p>';
					  						echo selectQuery_HTMLTable("SELECT DISTINCT titre, 																	date_retour 
																					FROM emprunter em, exemplaire ex, documents d
																					WHERE d.id_doc=ex.ex_id_doc AND ex.code_barre_exemplaire = 
																					'$id_ex';");
					  					}
					  				}

					  				pg_free_result ($result2);
					  				
						  	
					  			}
				  			}
			  			}
			  		?>

				  					
			</article>
			<!-- /Article -->
		</div>
</div>	<!-- /container -->
	
<?php	
	include "include/footer.php";
?>

