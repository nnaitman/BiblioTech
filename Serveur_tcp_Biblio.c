#include <netinet/in.h>
#include <sys/socket.h>
#include <string.h>
#include <stdio.h>
#include <arpa/inet.h>
#include </usr/local/pgsql/include/libpq-fe.h>
#include <stdlib.h>

//////////////////////////////////////////////////////////////////////////////////
/*Pour compiler :  cc -c -I/usr/local/pgsql/include serveur_tcp.c               //
		   cc -o serveur_tcp serveur_tcp.o -L/usr/local/pgsql/lib -lpq  //
		   ./serveur_tcp                  				//
*/////////////////////////////////////////////////////////////////////////////////

// Fonction premettant de retourner une souschaine d'une chaine 
char *substr(char *src,int pos,int len) { 
  char *sschaine=NULL;                        
  if (len>0) {                  
    /* allocation et mise à zéro */          
    sschaine = calloc(len+1, 1);      
    /* vérification de la réussite de l'allocation*/  
    if(NULL != sschaine) {
        strncat(sschaine,src+pos,len);            
    }
  }                                       
  return sschaine;                            
}

void fermeture(PGconn *conn, PGresult *res){

    fprintf(stderr, "%s\n", PQerrorMessage(conn));

    PQclear(res);

    PQfinish(conn);

}

//fonction evaluant l'etat du resultat de la requête

void requestStatus(ConnStatusType status,PGconn *connexion){

    switch (status){

        case CONNECTION_OK:

            printf("La connexion est établie.\n");

            break;

        case CONNECTION_BAD:

            printf("La connexion n'est pas établie. %s \n",PQerrorMessage(connexion));

            break;

        case CONNECTION_STARTED:

            break;

        case CONNECTION_MADE:

            break;

        case CONNECTION_AWAITING_RESPONSE:

            break;

        case CONNECTION_AUTH_OK:

            break;

        case CONNECTION_SETENV:

            break;

        case CONNECTION_SSL_STARTUP:

            break;

        case CONNECTION_NEEDED:

            break;

        default:

            printf("aucune valeur ne correspond");

            break;

    }

}


char *SQLrequest(PGconn *connexion,const char *request_name,PGresult *res){

    char *response=NULL;

    ConnStatusType status = PQstatus(connexion);

    requestStatus(status,connexion);

    

    printf("vous avez effectué la requête: %s\n",request_name);

    

    res = PQexec(connexion, request_name);

    

    //verification de la reception de la donnée demandée

    if(PQresultStatus(res) != PGRES_TUPLES_OK){

        printf("le tuple(ligne) demandé(e) est manquant(e),veillez le(a) remplir.\n");

    //recupération du nombre de ligne et de colonne

    }else{
	int nb_lignes = PQntuples(res);

    	int nb_colonnes = PQnfields(res);
    	for(int i=0; i<nb_lignes; i++){

        	for(int j=0; j<nb_colonnes; j++){

            		if(j==PQnfields(res)-1){
			response=PQgetvalue(res,i,j);

            		} else{
			response=PQgetvalue(res,i,j);

			}

            	} 

        }

    }
     if(response == NULL)
	 return "ERROR, SCAN FAILED";
     else
	 return response;
}

void main (int argc,char *argv[]) {
	char buf [80] ;
	char buf1[80] ;
	char *response=NULL;
	
	char *nom_a=NULL;
	char titre [50];
	char titre1 [50];
	
	int port = atoi(argv[1]);	

	char *query=NULL;
	
	
	PGresult *res=NULL,*res2=NULL;
	// Coonexion à la base de données
        PGconn *connexion = PQconnectdb("host=localhost port=5432 user=djohra password=A123456* dbname=postgres");

	int s_ecoute, s_dial, cli_len ;
	struct sockaddr_in serv_addr, cli_addr ;

	serv_addr.sin_family = AF_INET ;
	serv_addr.sin_addr.s_addr = INADDR_ANY ;
	serv_addr.sin_port = htons (port) ; //Numéro de port qu'on rentre au moment de l'exécution, sans avoir à recompiler !
	memset (&serv_addr.sin_zero, 0, sizeof(serv_addr.sin_zero));
	
	// PF_INET : Pour la famille de protocole IP , SOCK_STREAM : mode connecté (TCP), Protocole toujours à 0 dans IP

	s_ecoute = socket (PF_INET, SOCK_STREAM, 0) ;
	bind (s_ecoute, (struct sockaddr *)&serv_addr, sizeof serv_addr) ;

	listen (s_ecoute, 5) ; //le serveur attend une connexion
	cli_len = sizeof (cli_addr) ;
	s_dial = accept (s_ecoute, (struct sockaddr *)&cli_addr, &cli_len) ;
	printf ("Le client d'adresse IP %s s'est connecté depuis son port %d\n", \
	            inet_ntoa (cli_addr.sin_addr), ntohs (cli_addr.sin_port)) ;

	while(1){

		memset (buf, 0, 80); 
		read (s_dial, buf, 80) ; //on écrit sur le buffer le message du client 
		int i=0;
	   	
				if (strlen(buf)==80){		// si le message est trop long, break (on sort) !
					i++;
				}else{
					i=0;                    
				}
				if (i==1){
					printf("Message trop grand.\n");
					break;
				} 

		// appel à la fonction strstr pour savoir si le message envoyé par le client contient la chaine "cd"
		char * result = strstr( buf, "cd" );
		
		
		/* si le message envoyé ne contient pas cd, alors le serveur devra suivre ces instructions, on saura alors ici
		   qu'il ne s'agit pas d'un code barre */
	    if ( result != NULL ) {
			printf ("J'ai recu [%s] du client\n", buf) ;
			// ON récupère la sous chaine, à partir de la position 2 jusqu'à la position 5, du buffer ( tout ce qu'il y a apr_s "cd")
		  	char *var=substr(buf,2,5);
		
		  //On met la sous chaine qu'on a récupéré dans la requête SQL 
       		  sprintf(query,"SELECT d.titre FROM exemplaire e,documents d WHERE code_barre_exemplaire='%s' AND d.id_doc=e.ex_id_doc;",var);
		  response=SQLrequest(connexion,query,res);
		  //On copie dans une variable "titre1", le résultat de la requête précédante !
		  strcpy(titre1,response); 
	 	 
		  write (s_dial, response, strlen (response)) ;
        	  printf ("J'ai envoye [%s] au client\n", query) ;

		 
	 }else{

				//condition pour tester la connexion à la BD 
				if (!strncmp (buf, "test", strlen ("test"))) { 
					printf ("J'ai recu [%s] du client\n", buf) ;
					query=SQLrequest(connexion,"SELECT prenom_a FROM auteur1 WHERE prenom_a='Anna';",response);
					write (s_dial, query, strlen (query)) ;
					printf ("J'ai envoye [%s] au client\n", query) ;}

				
				// Evaluation d'un livre, quand le client écrit "Evaluation"
				if(!strncmp (buf, "Evaluation", strlen ("Evaluation"))) {
				
					memset (buf,0, 80); //Vider le buffer 
					strcpy (buf,"donnez une note au document\n"); //copier la chaine dans le buffer 
					write (s_dial, buf, strlen (buf)) ; //Afficher le message au client 
					printf ("J'ai envoye [%s] au client\n", buf) ;
					
					memset (buf, 0, 80); 
					read (s_dial, buf, 80) ;
					printf ("J'ai reçu [%d] du client\n", atoi(buf)) ;
					
					// Tant que la note > 5, redemnder au client une nouvelle note, répéter jusqu'à ce que la note soit <=5 !
					do{
						strcpy (buf,"ERROR 415, redonnez une note au document\n");
						write (s_dial, buf, strlen (buf)) ;
						printf ("J'ai envoye [%s] au client\n", buf) ;
						memset (buf,0, 80);
						read (s_dial, buf, 80) ;
						printf ("J'ai reçu [%d] du client\n", buf) ;
					//on convertit la chaine entrée en entier avec atoi
					} while( atoi(buf)>5 );

					//Lorsque la note est <=5, On effectue un UPDATE dans la table document afin de modifier la note !
					sprintf(query,"UPDATE documents SET note='%d' WHERE titre='%s' ;",atoi(buf),titre1); 
					response=SQLrequest(connexion,query,res);
					memset (buf, 0, 80);
					strcpy (buf,"Evaluation effectuée");
					write (s_dial, buf, strlen (buf)) ;}

	   			 //Lorsque le client envoie Bye, le serveur et client s'arrêtent 
				 if (!strncmp ( buf, "Bye", strlen ("Bye"))) {
					break;}

				
		}
		
		
       		memset (buf, 0, 80);
        	strcpy (buf, "\n") ;
        	write (s_dial, buf, strlen (buf)) ;
        	printf ("J'ai envoye [%s] au client\n", buf) ;

		
		
	} 
	close (s_dial) ; 
	close (s_ecoute) ;


}
