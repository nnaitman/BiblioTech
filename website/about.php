<?php
	
	include ('headers.php');
	include "connexion_bd/dbconnect.php";	
    include "include/fonctions_postgresql.inc.php";
    
?>
	<!-- container -->
	<div class="container">

		<ol class="breadcrumb">
			<li><a href="main.php">Home</a></li>
			<li class="active">About</li>
		</ol>

		<div class="row">
			
			<!-- Article main content -->
			<article class="col-sm-8 maincontent">
				<header class="page-header">
					<h1 class="page-title">About us</h1>
				</header>
				<h3>Description du projet Biblio'Tech</h3>
				<p><img src="assets/images/mac.jpg" alt="" class="img-rounded pull-right" width="300" > 					L’objectif principal de notre projet sera de mettre en place un outil de gestion 
				d’une bibliothèque afin de permettre et de faciliter les différentes actions liées à la 
				gestion globale de cette dernière: gestion d’utilisateurs et ajout, emprunt, restitution 
				des livres. Il aura pour but de classer les différents documents d’une bibliothèque 
				(livres, documents numériques, archives...). </p>
				
				<h3>Caractéristiques du projet</h3>
				<p>Chaque adhérent est identifié par un: numéro, nom, prénom et date de naissance. Et 
				chaque document cité antérieurement, est identifié par: un numéro, un titre, le nom 
				de l’auteur, l’année d’édition et la maison d'édition.
 
				Dans la partie réseau, le client aura la possibilité de scanner le code barre du livre, 
				et ainsi avoir, grâce au serveur réseau,  les informations relatives à ce dernier. Le 
				client pourra également évaluer un document ou livre, en donnant des points de 1 à 
				5 selon son appréciation. Ces points seront ensuite enregistrés dans la base de 
				données, afin de permettre aux futurs emprunteurs du même document/livre, de 
				voir les avis de ses utilisateurs précédents.</p>
				
			</article>

            <aside class="col-sm-4 sidebar sidebar-right">
                <h3>Nos auteurs de livres</h3>
		        <p>	pour avoir des informations techniques d'un document, sélectionnez en un.</p>
	            <div class="row">
	                <form method="POST" action="auteurs.php">
			            <div class="col-lg-4 text-right">
							<button name="sbm1" class="btn btn-action" type="submit">Afficher nos auteurs</button>
						</div>
					</form>
                </div>		
            </aside>

            <aside class="col-sm-4 sidebar sidebar-right">
                <h3>Genres & Livres</h3>
		        <p>	Sélectionnez un genre, pour voir les livres associés.</p>
	            <div class="row">
	            	<form method="POST" action="genres.php">
	            		<fieldset>
							<label>Genres</label>
							<?php

							//Une liste déroulante de tous les genres de nos livres 
	            				echo selectColumn_HTMLScrList("SELECT DISTINCT genre FROM documents");
            				?>
            			<input value="Sélectionner" name="OK" class="btn btn-action" type="submit">
					</fieldset>

	            </div>	
            </aside>
		</div>
	</div>
	

<?php	
	include "include/footer.php";
?>
