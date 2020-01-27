package client;

import java.io.IOException ;
import java.io.BufferedReader ;
import java.io.InputStreamReader ;
import java.io.PrintWriter ;
import java.io.IOException ;
import java.net.Socket ;
import java.net.UnknownHostException ;
import java.net.SocketException;
import java.net.SocketTimeoutException;
import java.net.ConnectException;


public class MainClient {

	public static void main (String argv []) throws IOException {
        Socket socket = null ;
        PrintWriter flux_sortie = null ;
        BufferedReader flux_entree = null ;
        String chaine ;

        try {
            // deuxieme argument : le numero de port que l'on contacte
	    int port =Integer.parseInt(argv[0]);
            socket = new Socket ("127.0.0.1", port) ;
	    socket.setSoTimeout(20000); //20s
            flux_sortie = new PrintWriter (socket.getOutputStream (), true) ;
            flux_entree = new BufferedReader (new InputStreamReader (
                                        socket.getInputStream ())) ;
        } 
        catch (UnknownHostException e) {
            System.err.println ("Hote inconnu") ;
            System.exit (1) ;
       }
	catch (ConnectException e){
	    System.err.println("Connexion refusée");
	    e.printStackTrace();
	    System.exit (1);
	}	

 

	// L'entree standard
        BufferedReader entree_standard = new BufferedReader ( new InputStreamReader ( System.in)) ;

	do {
		// on lit ce que l'utilisateur a tape sur l'entree standard
		chaine = entree_standard.readLine () ;
		chaine += "\0";


		// et on l'envoie au serveur
		flux_sortie.println (chaine) ;

		// on lit ce qu'a envoye le serveur
		try {
		chaine = flux_entree.readLine () ;
		}catch (SocketTimeoutException so) {
					System.out.println("timeout\n");
					so.printStackTrace();
					break;
		}
		catch (SocketException e) {
				System.out.println("perte de connexion");
				e.printStackTrace();
				break;
		}

		// et on l'affiche à l'ecran
		if (chaine == null ) { break;      } 
		else { System.out.println ("Le serveur m'a repondu : " + chaine) ;}
	}

	

	while (chaine != null) ;

        flux_sortie.close () ;
        flux_entree.close () ;
        entree_standard.close () ;
        socket.close () ;
	}


}
