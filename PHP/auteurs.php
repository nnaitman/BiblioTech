<?php
	session_start();
    include ('headers.php');
    include"connexion_bd/dbconnect.php";
    include "include/fonctions_postgresql.inc.php";    
?>
	<div class="container">
        <div class="row">   
        
            <?php

                //On sélectionne nos auteurs de livres 
           	 	echo selectQuery_HTMLTable("SELECT prenom_a, nom_a, nationalite, domaine FROM auteur");
        	?>

        </div>
    </div>

<?php
    include "include/footer.php";
?>
    


