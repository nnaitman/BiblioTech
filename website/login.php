<?php
session_start();
include('connexion_bd/dbconnect.php');


if (isset($_POST['sbm'])) {

    
    
   //on récupère les données du formulaire
    if(isset($_POST['username'])&&isset($_POST['password'])) {

           
        $uid = $_POST['username']; 
        $pwd = $_POST['password'];

        //$passhash= password_hash($pwd, PASSWORD_BCRYPT,$options);
        
        //On vérifie si les champs du formulaire sont bien remplis

        if (empty($uid) || empty($pwd)) {
            header("Location: ./index.php?login=empty");
            exit();
        } 

        else {

            if($uid == "az100211"){
                
                $query = "SELECT mot_pass
                            FROM adherent
                            WHERE login ='$uid';"; 
                                           
                $result = pg_query($connexion, $query) or die ('Echec de la requete : ' . pg_last_error());
                $hash=pg_fetch_result($result,0);
        
                //si l'utilisateur n'est pas sur la DB
        
                if($hash == '') {
                    echo '<script>
                            userDenied();
                          </script>';
                }

                else {
                        if(password_verify($pwd , $hash)) {
                            $_SESSION['username'] = $uid;
                            header("Location: ./main.php?login=success");
                            exit();
                        }
                }
            }

            else {
                
                $sql = "SELECT mot_pass 
                        FROM adherent 
                        WHERE login='$uid';";

                $result = pg_query($connexion, $sql)or die('Erreur1 SQL!'.pg_last_error());
                $pass = pg_fetch_result($result,0,0);

                //On vérifie si le mot de passe saisi correspond bien à celui hashé dans la base de données
                if(password_verify($pwd , $pass)) {
                    $_SESSION['username'] = $uid;

                    //On affiche dans l'en-tête success si authentification réussie
                    header("Location: ./main.php?login=success");
                    exit();
                }

                else{

                    //Sinon, on affiche error1
                    header("Location: ./index.php?login=error1");
                    exit();
                } 
            }
        }
    }
}

?>



