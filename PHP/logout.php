<?php   
session_start(); //On s'assure qu'on est bien dans la même session
session_destroy(); //On "détruit" cette session
header("location: ./index.php"); //Une redirection vers la page de connexion, après déconnexion
exit();
?>