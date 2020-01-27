<?php
include ('headers.php');

?>
	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="index.php">Connexion</a></li>
			<li class="active">Inscription</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-xs-12 maincontent">
				<header class="page-header">
					<h1 class="page-title">Inscription</h1>
				</header>
				
				<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-default">
						<div class="panel-body">
							<h3 class="thin text-center">Créer votre espace personnel</h3>
							<p class="text-center text-muted">Si vous possédez déjà un espace personnel, vous devez alors vous <a href="index.php">connecter</a> à ce dernier. Ne perdez plus de temps!</p>
							<hr>

							<form action="#" method="POST">
								<div class="top-margin">
									<label>Login<span class="text-danger">*</span></label>
									<input name="id_ad" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Nom<span class="text-danger">*</span></label>
									<input name="nom_ad" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Prénom<span class="text-danger">*</span></label>
									<input name="prenom_ad" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Date de naissance<span class="text-danger">*</span></label>
									<input name="date_nais" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Statut<span class="text-danger">*</span></label>
									<input name="stat" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Email<span class="text-danger">*</span></label>
									<input name="email" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Téléphone<span class="text-danger">*</span></label>
									<input name="tel" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Rue<span class="text-danger">*</span></label>
									<input name="rue_ad" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Ville<span class="text-danger">*</span></label>
									<input name="ville_ad" type="text" class="form-control">
								</div>

								<div class="top-margin">
									<label>Code Postal<span class="text-danger">*</span></label>
									<input name="cd_pst" type="text" class="form-control">
								</div>

								<div class="row top-margin">
									<div class="col-sm-6">
										<label>Password <span class="text-danger">*</span></label>
										<input name="password" type="password" class="form-control">
									</div>
									<div class="col-sm-6">
										<label>Confirm Password<span class="text-danger">*</span></label>
										<input name="retyped_password" type="password" class="form-control">
									</div>
								</div>

								<hr>

								<div class="row">
									<div class="col-lg-4 text-right">
										<button name="sbm5" class="btn btn-action" type="submit">M'inscrire</button>
									</div>
								</div>
							</form>

							<?php
							
        					if (isset($_POST['sbm5'])) {

        						//On récupère les données du formulaire, relatives à un nouvel adhérent de cette bibliothèque

                				$uid = $_POST['id_ad'];
                				$nom = $_POST['nom_ad'];
                				$prenom = $_POST['prenom_ad'];           
                				$e_mail = $_POST['email'];  
                				$birth = $_POST['date_nais']; 
                				$statu = $_POST['stat'];     
                				$rue = $_POST['rue_ad']; 
                				$ville = $_POST['ville_ad']; 
                				$code_postal = $_POST['cd_pst'];
                				$password = $_POST['password'];
                				$retyped_password = $_POST['retyped_password'];
                				$tel = $_POST['tel'];


                				//On vérifie que les champs ne sont pas vides
                				if ($uid == '' || $nom == '' || $prenom == '' || $e_mail == '' || $birth == '' || $statu == '' || $rue == '' || $ville == '' || $code_postal == '' || $password == '' || $retyped_password == '' || $tel == '') {

                    			//echo '<h2>Fields Left Blank</h2>', '<p>Some Fields were left blank. Please fill up all fields.</p>';
                    				echo '<p class="msg_emprunt">'."Les champs sont restés vides\n".'</p>';

                				} 
                				//On vérifie si le mot de passe resaisi correspond au premier saisi

                				elseif ($password != $retyped_password) {

                    				echo "<h2>Passwords Don't Match</h2>", "<p>The Passwords you entered didn't match</p>";

                				} 
                				else {

                    				include_once "connexion_bd/dbconnect.php";

                    				//On vérifie que le username saisi apparaît dans la table "adherent"

                    				$query= "SELECT COUNT(*) FROM adherent where login ='$uid';";

                    				$result = pg_query($query) or die ('Echec de la requete : ' . pg_last_error()); 

                    				$loginExist=pg_fetch_result($result,0);

                    				//On vérifie si le username existe bien dans la base de données. En vérifiant le nombre d'occurence de ce username dans la table "adherent". Si différente de 0 donc existe bien

                    				 if($loginExist != 0) {
                        				echo' <script>login();</script>';
                    				}else{
                        			//HASH password 
                        				$options = [
                        				'cost' => 12,
                        				];

                        				$passhash= password_hash($password, PASSWORD_BCRYPT,$options);
                        				
                    				}		

                    				//On insert le nouvel adherent 
                    				$query = "INSERT INTO adherent VALUES ('$uid','$nom','$prenom','$passhash','$statu','$e_mail','$rue','$ville','$code_postal','$tel','$birth');"; 

                    				$result = pg_query($connexion, $query) or die('Erreur1 SQL!'.pg_last_error());
                    
                    				//echo '<p class="msg_emprunt">'."Vous vous êtes bien 				inscrit\n".'</p>';
                    				echo "<label>Success. Created account. <a href='index.php'>Log In</a></label>";

                    				pg_free_result ($result); 

                				}
           					}
							?>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>	<!-- /container -->

<?php

	include "include/footer.php";

?>



	

	