<?php
	include('headers.php');
	include "include/fonctions_postgresql.inc.php";
	include "connexion_bd/dbconnect.php";
?>
	<article>
		 
		<div>

			<?php
				//On sélectionne le titre des documents appartenant à un genre que l'utilisateur choisira
				if(isset($_POST['OK']) && isset($_POST['genre'])){
					$gnr=$_POST['genre'];
            		echo selectQuery_HTMLTable("SELECT titre
												FROM documents
												WHERE genre='$gnr'");
    			}

			?>
									
		</div>		

	</article> 

<?php	
	require_once"include/footer.php";
?>