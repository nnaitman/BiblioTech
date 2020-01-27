CREATE TABLE documents
( 
    id_doc CHAR(5),
    note integer,
    titre text,
    genre VARCHAR(40),
    CONSTRAINT documents_pk PRIMARY KEY (id_doc)
);

CREATE TABLE exemplaire
( 
    code_barre_exemplaire CHAR(5),
    date_aquisition DATE,
    disponibilite BOOLEAN DEFAULT false,
    ex_id_doc CHAR(5),
    CONSTRAINT  exmp_fk FOREIGN KEY (ex_id_doc) REFERENCES documents (id_doc) ON DELETE CASCADE,
    CONSTRAINT exemplaire_pk PRIMARY KEY (code_barre_exemplaire) 
);

CREATE TABLE livre 
( 
    id_livre  CHAR(5),
    annee_edition INT,
    maison_edition VARCHAR(30),
    resume text,
    CONSTRAINT livre_pk PRIMARY KEY (id_livre),
    CONSTRAINT livre_fk FOREIGN KEY (id_livre) REFERENCES documents (id_doc) ON DELETE CASCADE
);

CREATE TABLE revue
( 
    id_rev  CHAR(5),
    date_parution DATE,
    CONSTRAINT revue_pk PRIMARY KEY (id_rev),
    CONSTRAINT revue_fk FOREIGN KEY (id_rev) REFERENCES documents (id_doc) ON DELETE CASCADE
);

CREATE TABLE auteur
( 
    id_auteur  CHAR(6),
    prenom_a VARCHAR(30),
    nom_a VARCHAR(30),	
    nationalite VARCHAR(25),
    domaine VARCHAR(50),
    CONSTRAINT auteur_pk PRIMARY KEY (id_auteur)
);


CREATE TABLE adherent
( 
    login  CHAR(8),
    nom VARCHAR(30),
    prenom VARCHAR(30),
    mot_pass text CHECK (char_length(mot_pass) >= 8),
    statut VARCHAR(22),
    email varchar,
    rue VARCHAR(30),
    ville VARCHAR(30),
    cd_postal VARCHAR(30),
    tel INTEGER,
    date_nais DATE,
    CONSTRAINT proper_email CHECK (email ~* '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+[.][A-Za-z]+$'),
    CONSTRAINT adherent_pk PRIMARY KEY (login)
);


CREATE TABLE ecrit
( 
    id_auteur  CHAR(6),
    id_doc CHAR(5),
    CONSTRAINT ecrit_fk1 FOREIGN KEY (id_auteur) REFERENCES auteur(id_auteur) ON DELETE CASCADE,
    CONSTRAINT ecrit_fk2 FOREIGN KEY (id_doc) REFERENCES documents(id_doc) ON DELETE CASCADE,
    CONSTRAINT ecrit_pk PRIMARY KEY (id_auteur,id_doc)
);

CREATE TABLE emprunter
( 
    code_barre_exemplaire  CHAR(5),
    login CHAR(8),
    date_retour DATE,
    CONSTRAINT emprunter_fk1 FOREIGN KEY (code_barre_exemplaire) REFERENCES exemplaire(code_barre_exemplaire) ON DELETE CASCADE,
    CONSTRAINT emprunter_fk2 FOREIGN KEY (login) REFERENCES adherent(login) ON DELETE CASCADE,
    CONSTRAINT emprunter_pk PRIMARY KEY (code_barre_exemplaire,login)
);

CREATE TABLE restituer
( 
    code_barre_exemplaire  CHAR(5),
    login CHAR(8),
    date_rest DATE,
    CONSTRAINT restituer_fk1 FOREIGN KEY (code_barre_exemplaire) REFERENCES exemplaire(code_barre_exemplaire) ON DELETE CASCADE,
    CONSTRAINT restituer_fk2 FOREIGN KEY (login) REFERENCES adherent(login) ON DELETE CASCADE,
    CONSTRAINT restituer_pk PRIMARY KEY (code_barre_exemplaire,login)
);

ALTER TABLE documents add CONSTRAINT notechk CHECK (note >= 0 AND note <= 5);

--Insert dans la table document

INSERT INTO documents VALUES('12300',5,'AFTER CHAPTER 1','romance');
INSERT INTO documents VALUES('10156',4,'Calendar girl','romance');
INSERT INTO documents VALUES('10563',5,'orgueils et préjugés','romance');
INSERT INTO documents VALUES('10345',4,'les hauts de hurlevents','romance');
INSERT INTO documents VALUES('10346',5,'The best of me','romance');
INSERT INTO documents VALUES('10347',5,'Le hobbit ','fantasy');
INSERT INTO documents VALUES('10348',3,'Le trône de fer','fantasy');
INSERT INTO documents VALUES('10349',3,'Le Seigneur des anneaux','fantasy');
INSERT INTO documents VALUES('10350',4,'Harry potter','fantasy');
INSERT INTO documents VALUES('10351',5,'Légende ','fantasy');
INSERT INTO documents VALUES('10352',5,'Steve jobs','biographie');
INSERT INTO documents VALUES('10353',4,'Un long chemin vers la liberté ','biographie');
INSERT INTO documents VALUES('10354',3,'Devenir','biographie');
INSERT INTO documents VALUES('10355',5,'Une vie','biographie');
INSERT INTO documents VALUES('10356',5,'Brûlée vive','biographie');
INSERT INTO documents VALUES('10357',4,'Aux portes de l"éternité','historique');
INSERT INTO documents VALUES('10358',5,'Une colonne de feu','historique');
INSERT INTO documents VALUES('10359',5,'Les Piliers de la terre','historique');
INSERT INTO documents VALUES('10360',5,'Un monde sans fin','historique');
INSERT INTO documents VALUES('10361',4,'Le pouvoir du moment présent','personnel');
INSERT INTO documents VALUES('10362',5,' Ta deuxième vie commence quand tu comprends que tu n’en as qu’une','personnel');
INSERT INTO documents VALUES('10363',2,'Miracle morning','personnel');
INSERT INTO documents VALUES('10364',5,'Le jour où jai appris à vivre','personnel');
INSERT INTO documents VALUES('10365',5,'l"homme qui voulait être heureux','personnel');
INSERT INTO documents VALUES('10366',5,'Le Chien des Baskerville','policier');
INSERT INTO documents VALUES('10367',5,'Double Assassinat dans la rue Morgue','policier');
INSERT INTO documents VALUES('10369',5,'Le Meurtre de Roger Ackroyd','policier');
INSERT INTO documents VALUES('10370',5,'Mort sur le Nil','policier');
INSERT INTO documents VALUES('14001',5,'foot mercato','sport');

--Insert dans la table exemplaire

INSERT INTO exemplaire VALUES(00001,'01-01-2019',true,'12300');
INSERT INTO exemplaire VALUES(00002,'01-02-2019',true,'10156');
INSERT INTO exemplaire VALUES(00003,'11-02-2019',true,'10563');
INSERT INTO exemplaire VALUES(00004,'11-02-2019',true,'10345');
INSERT INTO exemplaire VALUES(00005,'11-02-2019',true,'10346');
INSERT INTO exemplaire VALUES(00006,'11-03-2019',true,'10347');
INSERT INTO exemplaire VALUES(00007,'11-02-2019',true,'10348');
INSERT INTO exemplaire VALUES(00008,'11-02-2019',true,'10349');
INSERT INTO exemplaire VALUES(00009,'11-04-2019',true,'10350');
INSERT INTO exemplaire VALUES(00010,'11-02-2019',true,'10351');
INSERT INTO exemplaire VALUES(00011,'11-02-2019',true,'10352');
INSERT INTO exemplaire VALUES(00012,'11-02-2019',true,'10353');
INSERT INTO exemplaire VALUES(00013,'11-09-2019',true,'10354');
INSERT INTO exemplaire VALUES(00014,'11-02-2019',true,'10356');
INSERT INTO exemplaire VALUES(00015,'10-02-2019',true,'10357');
INSERT INTO exemplaire VALUES(00016,'11-02-2019',true,'10358');
INSERT INTO exemplaire VALUES(00017,'06-02-2019',true,'10359');
INSERT INTO exemplaire VALUES(00018,'11-02-2019',true,'10360');
INSERT INTO exemplaire VALUES(00019,'11-02-2019',true,'10361');
INSERT INTO exemplaire VALUES(00020,'05-02-2019',true,'10362');
INSERT INTO exemplaire VALUES(00021,'11-03-2019',true,'10363');
INSERT INTO exemplaire VALUES(00022,'11-02-2019',true,'10364');
INSERT INTO exemplaire VALUES(00023,'07-02-2019',true,'10365');
INSERT INTO exemplaire VALUES(00024,'11-05-2019',true,'10366');
INSERT INTO exemplaire VALUES(00025,'11-02-2019',true,'10367');
INSERT INTO exemplaire VALUES(00026,'11-02-2019',true,'10367');
INSERT INTO exemplaire VALUES(00027,'11-08-2019',true,'10369');
INSERT INTO exemplaire VALUES(00028,'11-02-2019',true,'10370');


--Insert dans la table livres

INSERT INTO livre VALUES('12300',2013,'HUGO ROMANCE','Tessa est une jeune fille ambitieuse, volontaire, réservée. Elle contrôle sa vie. Son petit ami, Noah, est le gendre idéal. Celui que sa mère adore, celui qui ne fera pas de vagues. Son avenir est tout tracé  : de belles études, un bon job à la clé, un mariage heureux. Mais ça, c était avant quil ne la bouscule dans le dortoir. Lui, c est Hardin, bad boy, sexy, tatoué, piercé. Grossier, provocateur et cruel, c’est le type le plus détestable que Tessa ait jamais croisé. Et pourtant, le jour où elle se retrouve seule avec lui, elle perd tout');
INSERT INTO livre VALUES('10156',2016,'HUGO ROMANCE','Mia Saunders rêve de devenir actrice, elle a quitté Las Vegas où elle vivait avec sa sœur et son père pour s’installer à Los Angeles. Mais elle va devoir revoir ses projets, car Mia a besoin d’argent, de beaucoup d’argent. Elle doit en effet rembourser les dettes de jeu de son père. Un million de dollars.');

INSERT INTO livre VALUES('10563',1813,'Thomas Egerton','La campagne anglaise à la fin du XVIIIe siècle. Mrs. Bennet et son mari sont ravis d apprendre qu un jeune homme fortuné - et célibataire - vient de s installer dans le manoir voisin. Désargentés, les Bennet se font fort de marier l une de leurs cinq filles au nouvel arrivant... Ce dernier ne tarde pas à s éprendre de la belle Jane, l aînée de la famille, lors d un bal de campagne.');

INSERT INTO livre VALUES('10345',1847,'Thomas Cautley Newby','Une histoire d''amour et de vengeance dans un paysage sauvage de l''Angleterre : Mr Earnshaw, père d''Hindley et de Catherine, adopte Heathcliff qui tombe amoureux de Catherine tandis qu une rivalité s instaure entre lui et Hindley');

INSERT INTO livre VALUES('10346',2014,'HUGO ROMANCE','Tout le monde veut croire en l''amour éternel. Elle aussi y a cru à l''âge de dix-huit ans. Alors que leur dernière année universitaire touche à sa fin, Amanda et Dawson, unis par un amour sans limite, ne s''imaginent pas vivre l''un sans l''autre. De milieux sociaux très différents, ils luttent contre les préjugés de la petite ville d''Oriental en Caroline du Nord. Mais des événements imprévus vont les amener à emprunter des chemins radicalement différents.');

INSERT INTO livre VALUES('10347', 1937,'Allen & Unwin','Dans ce livre est conté l''histoire de Bilbo Sacquet, Hobbit aventureux (à la différence du reste des Hobbits). Celui-ci reçut un jour la visite de Gandalf le magicien, accompagné de Thorin Oakenshield (chef très important parmi les nains) et de sa troupe constituée de 13 joyeux nains.');

INSERT INTO livre VALUES('10348', 1996,'Allen & Unwin','La capitale, Port-Réal, doit quant à elle faire face à un problème plus pressant : le Roi Robert Baratheon vient de perdre son bras droit. ... Mais peu avant le départ pour la capitale, l''un des fils de Stark découvre un secret que nul n''aurait jamais dû connaître');

INSERT INTO livre VALUES('10349', 1996,'Allen & Unwin','Un jeune et timide `Hobbit'', Frodon Sacquet, hérite d''un anneau magique. Bien loin d''être une simple babiole, il s''agit d''un instrument de pouvoir absolu qui permettrait à Sauron, le Seigneur des ténèbres, de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon doit parvenir jusqu à la Crevasse du Destin pour détruire l''anneau.');

INSERT INTO livre VALUES('10350', 2001,'Bloomsbury','Orphelin, le jeune Harry Potter peut enfin quitter ses tyranniques oncle et tante Dursley lorsqu''un curieux messager lui révèle qu''il est un sorcier. À 11 ans, Harry va enfin pouvoir intégrer la légendaire école de sorcellerie de Poudlard, y trouver une famille digne de ce nom et des amis, développer ses dons, et préparer son glorieux avenir.');

INSERT INTO livre VALUES('10354', 2018,'Crown Publishing Group','Il y a encore tant de choses que j''ignore au sujet de l''Amérique, de la vie, et de ce que l''avenir nous réserve. Mais je sais qui je suis. Mon père, Fraser, m''a appris à travailler dur, à rire souvent et à tenir parole. Ma mère, Marian, à penser par moi-même et à faire entendre ma voix. Tous les deux ensemble, dans notre petit appartement du quartier du South Side de Chicago, ils m''ont aidée à saisir ce qui faisait la valeur de notre histoire, de mon histoire, et plus largement de l''histoire de notre pays.');

INSERT INTO livre VALUES('10356', 2003,'Crown Publishing Group','Brûlée vive parce qu'' « on » l''avait vue parler à un garçon ! Souad est née en Cisjordanie. ... Sa mère a mis au monde un seul garçon, au milieu de plein de filles.');

INSERT INTO livre VALUES('10358', 2017,'Bloomsbury','Noël 1558, le jeune Ned Willard rentre à Kingsbridge. Il découvre une ville déchirée par la haine religieuse, et se retrouve dans le camp adverse de celle qu''il voulait épouser, Margery Fitzgerald.
L''accession d''Élisabeth Ire au trône met le feu à toute l''Europe, et les complots pour destituer la jeune souveraine se multiplient. ');


--insert dans auteur

INSERT INTO auteur VALUES ('50001', 'Anna', 'Todd','americaine','romancier');
INSERT INTO auteur VALUES ('50002', 'Audrey', 'Carlan','americaine','romancier');
INSERT INTO auteur VALUES ('50003', 'John Ronald Reuel', 'Tolkein','brittanique','écrivain, poète, philologue, essayiste');
INSERT INTO auteur VALUES ('50004', 'George Raymond Richard', 'Martin','americaine','ecrivain,scenariste,producteur');
INSERT INTO auteur VALUES ('50005', 'Ken', 'Follett','galois','romancier');
INSERT INTO auteur VALUES ('50006', 'Eckhart', 'Tolle','canadienne','ecrivain et conférencier');
INSERT INTO auteur VALUES ('50007', 'Hal', 'Elrod','americaine','ecrivain');
INSERT INTO auteur VALUES ('50008', 'Arthur Conan', 'Doyle','britannique','écrivain et médecin');
INSERT INTO auteur VALUES ('50009', 'Agatha', 'Christie','britannique','romancier');



--inser dans adherent

insert into adherent values('az100211','grenville','jean patrick','motdepass','salarié','jeanpa@societe3.com','avenue george moulin','aix en provence','13100','0612121348','03-12-1978');
insert into adherent values('az100212','idrissou','hamza','fluR54.Jo?At58,','etudiant','idrissouhamza044@gmail.com','avenue adolphe chauvin','valdoise','95300','0600000000','01-10-1998');
insert into adherent values('az100213','kolibaly','kalidou','ubuntuuuuuu','salarié','kalidkbl@societe4.com','rue de la caplette','aubervillier','93300','0715987456','21-05-1980');
insert into adherent values('az100214','charlotte','katakuri','imtheonepiece','sans profession','charkatakuri@eastblue.fr','rue des bonbons','tot land','99999','0154859562','25-11-1971');
insert into adherent values('az100215','wayne','bruce','darkknight','salarié','brucew@arkham.com','avenue de la chauve souris','gotham city','999999','0612345678','13-01-1939');
insert into adherent values('az100216','merkel','Angela Dorothea','chancelier123','salarié','angelmer@yahooo.com','kanzlemart','hambourg','99999','0612124589','17-07-1954');
insert into adherent values('az100217','parker','peter','petparspider','etudiant','petersp@smail.com','rue queens','new york city','99999','0658745987','15-08-1962');

--insert dans ecrit

insert into ecrit values ('50001','12300');
insert into ecrit values ('50002','10156');
insert into ecrit values ('50003','10347');
insert into ecrit values ('50004','10348');
insert into ecrit values ('50005','10357');
insert into ecrit values ('50005','10358');
insert into ecrit values ('50006','10361');
insert into ecrit values ('50007','10363');
insert into ecrit values ('50008','10366');
insert into ecrit values ('50009','10369');

--insert dans emprunter

insert into emprunter values ('27','az100213','10-11-2019');
insert into emprunter values ('16','az100214','09-10-2019');
insert into emprunter values ('6','az100216','05-09-2019');
insert into emprunter values ('7','az100211','29-10-2019');

--insert dans restituer

insert into restituer values ('27','az100212','10-11-2019');
insert into restituer values ('16','az100216','14-11-2019');
insert into restituer values ('15','az100215','10-10-2019');
insert into restituer values ('7','az100216','30-11-2019');

--insert dans revue

insert into revue values ('14001','16-05-2019');
