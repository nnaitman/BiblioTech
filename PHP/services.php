<?php
	
	include ('headers.php');
	include_once "connexion_bd/dbconnect.php";
?>

	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="main.php">Home</a></li>
			<li class="active">Ajout/Suppression</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-sm-9 maincontent">
				<header class="page-header">
					<h1 class="page-title">Ajout/Suppression</h1>
				</header>

				<h3>Suppression d'un livre</h1>				
				<br>
					<form method="POST" action="services.php#supp">
						<div class="row">
							<div class="col-sm-4">
								<input name="id_document" class="form-control" type="text" placeholder="ID Livre">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-6 text-right">
								<input name="sbm8" class="btn btn-action" type="submit" value="Supprimer">
							</div>
						</div>
					</form>

					<div class="supp">
					<?php
					if (isset($_POST['sbm8'])) {

						//On récupère l'ID du document à supprimer, saisi par l'utilisateur
						$id_docu = $_POST['id_document'];

						//On supprime le document correspondant à l'ID récupéré, de la table "documents"

						$query1="DELETE FROM documents WHERE id_doc='$id_docu';";

						//On exécute la requête DELETE
						$result1=pg_query($connexion, $query1) or die('Erreur SQL!' .pg_last_error());
    					

						if ($result1){
							echo '<p class="msg_emprunt">'."Document supprimé avec succès\n".'</p>';
						}
						else{
							echo'<p class="msg_emprunt">'."Echec de la suppression du document\n".'</p>';
						}

													
					}
    					
					?>
					</div>


			<h3>Ajout d'un livre</h1>

					<form method="POST" action="services.php#ajoutLivre">
								<div class="top-margin">
									<label>Id Livre<span class="text-danger">*</span></label>
									<input name="id_livre" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Titre du livre<span class="text-danger">*</span></label>
									<input name="title" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Genre<span class="text-danger">*</span></label>
									<input name="gnr" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Note<span class="text-danger">*</span></label>
									<input name="note" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Année d'édition<span class="text-danger">*</span></label>
									<input name="annee_edit" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Maison d'édition<span class="text-danger">*</span></label>
									<input name="maison_edit" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<div class="col-sm-12">
										<label>Résumé<span class="text-danger">*</span></label>
										<textarea name="resume" placeholder="écrivez le résumé ici..." class="form-control" rows="9"></textarea>
									</div>
								</div>

								<hr>

								<div class="top-margin">
									<div class="row">
									<div class="col-lg-4 text-right">
										<button name="sbm3" class="btn btn-action" type="submit">Ajouter</button>
									</div>
								</div>

					</form>

					<div class="ajoutLivre">
					<?php
					if (isset($_POST['sbm3'])) {

						//include_once "connexion_bd/dbconnect.php";

						//Dans un premier temps, on insère le nouveau livre dans la table "documents" de notre base de données.

						$query1= "INSERT INTO documents VALUES ('".$_POST['id_livre']."', '".$_POST['note']."', '".$_POST['title']."' , '".$_POST['gnr']."');";

						//Dans un deuxième temps, on insère ce même livre dans la table "livre"
						$query2= "INSERT INTO livre VALUES ('".$_POST['id_livre']."', '".$_POST['annee_edit']."', '".$_POST['maison_edit']."', '".$_POST['resume']."');";

    					$result1=pg_query($connexion, $query1);
    					$result2=pg_query($connexion, $query2);

						//Ces deux requêtes étant nécessaires et suffisantes pour l'ajout d'un livre à notre base de données, on vérifie si ces deux requêtes ne se sont pas exécutées pour retourner un message d'erreur

						if ((!$result1) || (!$result2)){
							echo pg_last_error();
						}
						else{
							echo '<p class="msg_emprunt">'."Ce document a été ajouté avec succès!\n".'</p>';
						}

													
					}
    					
					?>

					</div>

					<hr>

					<h3>Ajout d'un exemplaire</h1>
					<form method="POST" action="services.php#ajoutEX">
								<div class="top-margin">
									<label>Id Livre<span class="text-danger">*</span></label>
									<input name="id_livre" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Id Exemplaire<span class="text-danger">*</span></label>
									<input name="id_ex" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Date d'Acquisition<span class="text-danger">*</span></label>
									<input name="date_acq" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Disponibilité<span class="text-danger">*</span></label>

									<input type="radio" id="dispoChoice1" name="dispo" value="True">
									<label for="dispoChoice1">True</label>
									
									<input type="radio" id="dispoChoice2" name="dispo" value="False">
									<label for="dispoChoice2">False</label>
								</div>

								<hr>

								<div class="top-margin">
									<div class="row">
									<div class="col-lg-4 text-right">
										<button name="sbm7" class="btn btn-action" type="submit">Ajouter</button>
									</div>
								</div>

					</form>

					<hr>

					<div class="ajoutEx">
					<?php
					if (isset($_POST['sbm7'])) {

						//include_once "connexion_bd/dbconnect.php";

						//On ajoute, un exemplaire d'un livre en particulier en récupérant via un formulaire: son ID, sa date d'acquisition, sa disponibilité, et l'iD du livre auquel il correspond

						$query1= "INSERT INTO exemplaire VALUES ('".$_POST['id_ex']."', '".$_POST['date_acq']."', '".$_POST['dispo']."' , '".$_POST['id_livre']."');";


						$result1=pg_query($connexion, $query1) or die('Erreur SQL!' .pg_last_error());
    					

						if ($result1){
							echo '<p class="msg_emprunt">'."Exemplaire ajouté avec succès\n".'</p>';
						}
						else{
							echo'<p class="msg_emprunt">'."Echec de l'Ajout de l'exemplaire\n".'</p>';
						}

													
					}
    					
					?>
					</div>


			</article>
			<!-- /Article -->
		</div>
</div>	<!-- /container -->
	
<?php	
	require_once"include/footer.php";
?>