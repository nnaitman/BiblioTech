<?php
	include ('headers.php');
	
?>

	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="main.php">Home</a></li>
			<li class="active">Restituer</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-sm-9 maincontent">
				<header class="page-header">
					<h1 class="page-title">Réstituer</h1>
				</header>
				
				<p>
					Vous avez fini de lire un livre ou une revue? C'est l'heure de le restituer.
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
								<input name="sbm6" class="btn btn-action" type="submit" value="Restituer">
							</div>
						</div>
					</form>

					<hr>

					<?php
						
						if (isset($_POST['sbm6'])) {

							
						/*On récupère l'iD Adhérent et l'iD de l'exemplaire 
						saisis par l'utilisateur*/

							$id_ad = $_POST['id_adherent'];
							$id_ex = $_POST['id_exemplaire'];

						//On vérifie si les deux champs sont vides ou pas

							if($id_ad == '' || $id_ex==''){

								echo '<p class="msg_alert">Une erreur s\'est produite</p>';
							}
							else {

								//On récupère la ressource de connexion à notre base de données 

								include_once "connexion_bd/dbconnect.php";

								//Retourne la date actuelle
								$date_rest= date("Y-m-d");

								/*On séléctionne la date retour de l'exemplaire 
								de la table restituer*/
								
								$query= "SELECT date_retour FROM emprunter WHERE(code_barre_exemplaire = '$id_ex');";

								//On exécute la requête

								$result= pg_query($connexion, $query);

								//Si l'exécution s'est exécutée avec succès

								if($result){

					   				$date_retour = pg_fetch_result($result, 0);

					   				/*On calcule la différence de jours entre la date actuelle et la date de restitution présente dans la table restituer*/

					   				/*Si la différence est prositive donc la date limite est dépassée,
					   					Sinon, le délai est respecté */

									$diff = (strtotime($date_rest)-strtotime($date_retour))/86400;

									if ($diff > 0){
										echo '<p class="msg_alert">'."Vous avez dépassé le délai d'emprunt autorisé.\n".'</p>';
									}

									$query1= "INSERT INTO restituer 
									  VALUES ('$id_ex', '$id_ad','$date_rest');";	

						  			$result1= pg_query($connexion, $query1);

						  			if(!$result1){
						  				
						  				echo'<p class="msg_alert">Une erreur s\'est produite.</p>';
						   				echo pg_last_error();
					   				}

						  			
					  				
						  			pg_free_result ($result1); 

						  			/*Une fois l'exemplaire retitué, on change sa disponibilité à 'true'*/

						  			$query2= "UPDATE exemplaire 
									  SET disponibilite='true'
									  WHERE exemplaire.code_barre_exemplaire IN (SELECT exemplaire.code_barre_exemplaire FROM exemplaire,emprunter,adherent 
                                          WHERE exemplaire.code_barre_exemplaire='$id_ex' 
                                          AND adherent.login='$id_ad');";	

						  			$result2= pg_query($connexion, $query2);
						  			if (!$result2){
						  				echo'<p class="msg_alert">Une erreur s\'est produit.</p>';
						   				echo pg_last_error();
						  			} 

						  			/*else{
						  				echo '<p class="msg_emprunt">'."Vous avez bien restitué ce livre. Nous vous en remerçions.\n".'</p>';
						  			}*/
					  				

						  			pg_free_result ($result2);

						  			/*On supprime l'exemplaire retistué de la table emprunter*/ 

						  			$query3= "DELETE FROM emprunter
									  WHERE (code_barre_exemplaire= '$id_ex' 
									  		AND login='$id_ad');";



						  			$result3= pg_query($connexion, $query3);

						  			if (!$result3){

						  				echo'<p class="msg_alert">Une erreur s\'est produite.</p>';
						   				echo pg_last_error();
						  			} 

						  			else{
						  				echo '<p class="msg_emprunt">'."Vous avez bien restitué ce livre. Nous vous en remerçions.\n".'</p>';
					  				}

						  			pg_free_result ($result3);
					  		
					  			}
					  			
							}

						}
				  	?>

			</article>
			<!-- /Article -->
			<hr>
			<!-- Sidebar -->
			<aside class="col-sm-3 sidebar sidebar-right">

				<div class="wrapper">
					<input type="checkbox" id="st1" value="1"/>
						<label for="st1"></label>
					<input type="checkbox" id="st2" value="2"/>

					<label for="st2"></label>
						<input type="checkbox" id="st3" value="3"/>

					<label for="st3"></label>
						<input type="checkbox" id="st4" value="4"/>

					<label for="st4"></label>
						<input type="checkbox" id="st5" value="5"/>

					<label for="st5"></label>

				</div>

			</aside>
			<!-- /Sidebar-->

		</div>
	</div>	<!-- /container--> 
	
<?php	
	include "include/footer.php";
?>