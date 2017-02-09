# -----------------------------------------------------------------
#       TABLE : Client
# -----------------------------------------------------------------
--  Client (numClient, nomClient, prenomClient, adresse, numTelephone);
INSERT INTO Client VALUES('860313', 'Azevedo', 'Léo', 'rue du Père Nöel 45590 ST CYR EN VAL', '0638880001');
INSERT INTO Client VALUES('921026', 'Duperey', 'Anny', 'rue du Cinéma 45000 ORLEANS', '0238630002');
INSERT INTO Client VALUES('970212', 'Dupont', 'Patrick', 'rue des Planches 45160 OLIVET', '0238630003');
INSERT INTO Client VALUES('890101', 'Duteuil', 'Yves', 'rue de la Gratte 45400 FLEURY LES AUBRAY', '0238630004');

# -----------------------------------------------------------------
#       TABLE : Compte
# -----------------------------------------------------------------
--  Compte (numCompte, dateOuverture, depotInitial, numClient);
INSERT INTO Compte VALUES('CCHQ860313', '2001-01-01', 1000, '860313');
INSERT INTO Compte VALUES('LIVA860313', '2001-07-01', 1500, '860313');
INSERT INTO Compte VALUES('CEPL860313', '2003-07-01', 1500, '860313');
INSERT INTO Compte VALUES('CCHQ921026', '2002-01-01', 1000, '921026');
INSERT INTO Compte VALUES('LIVA921026', '2002-07-01', 1500, '921026');
INSERT INTO Compte VALUES('CCHQ970212', '2001-07-01', 1000, '970212');
INSERT INTO Compte VALUES('LIVA970212', '2003-01-01', 1000, '970212');
INSERT INTO Compte VALUES('CCHQ890101', '2004-01-01', 1000, '890101');

# -----------------------------------------------------------------
#       TABLE : CompteCourant
# -----------------------------------------------------------------
--  CompteCourant (numCompte, decouvert);
INSERT INTO CompteCourant VALUES('CCHQ860313', 1000);
INSERT INTO CompteCourant VALUES('CCHQ921026', 1500);
INSERT INTO CompteCourant VALUES('CCHQ970212', 2000);
INSERT INTO CompteCourant VALUES('CCHQ890101', 2500);

# -----------------------------------------------------------------
#       TABLE : SoldeCCDebutMois
# -----------------------------------------------------------------
--  SoldeCCDebutMois (numCompte, debutMois, soldeAReporter);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ860313', '2016-11-01', 1750);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ860313', '2016-12-01', 2500);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ921026', '2016-11-01', 1500);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ921026', '2016-12-01', -750);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ970212', '2016-11-01', 1000);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ970212', '2016-12-01', 2000);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ890101', '2016-11-01', 1500);
INSERT INTO SoldeCCDebutMois VALUES('CCHQ890101', '2016-12-01', 2500);

# -----------------------------------------------------------------
#       TABLE : CompteEpargne
# -----------------------------------------------------------------
--  CompteEpargne (numCompte, tauxInteret, soldePlancher);
INSERT INTO CompteEpargne VALUES('LIVA860313', 0.75, 100);
INSERT INTO CompteEpargne VALUES('CEPL860313', 1.25, 200);
INSERT INTO CompteEpargne VALUES('LIVA921026', 0.75, 100);
INSERT INTO CompteEpargne VALUES('LIVA970212', 0.75, 100);

# -----------------------------------------------------------------
#       TABLE : TypeCB
# -----------------------------------------------------------------
--  TypeCB (codeTypeCB, libelleTypeCB);
INSERT INTO TypeCB VALUES ('MC','MasterCard');
INSERT INTO TypeCB VALUES ('MG','MasterCard Gold');
INSERT INTO TypeCB VALUES ('VS','Visa');

# -----------------------------------------------------------------
#       TABLE : CarteBancaire
# -----------------------------------------------------------------
--  CarteBancaire (numCB, dateExpiration, codeTypeCB, numClientDetenteur, numCCSupport);
INSERT INTO CarteBancaire VALUES('MC860313', '2018-12-01', 'MC', '860313', 'CCHQ860313');
INSERT INTO CarteBancaire VALUES('VS860313', '2019-07-01', 'VS', '860313', 'CCHQ860313');
INSERT INTO CarteBancaire VALUES('MC921026', '2018-11-01', 'MC', '921026', 'CCHQ921026');
INSERT INTO CarteBancaire VALUES('VS970212', '2017-12-01', 'VS', '970212', 'CCHQ970212');
INSERT INTO CarteBancaire VALUES('MC890101', '2018-10-01', 'MC', '890101', 'CCHQ890101');

# -----------------------------------------------------------------
#       TABLE : Operation
# -----------------------------------------------------------------
--  Operation (codeOperation, dateOperation, libelleOperation, montantOperation
--           , typeOperation, numComptePivot, numCB);

INSERT INTO Operation VALUES('OP01__-->CCHQ860313','2016-12-02','Virement Remboursement',250
                            ,'Crédit','CCHQ860313',NULL);
INSERT INTO Operation VALUES('OP02__-->LIVA970212','2016-12-03','Virement Permanent',100
                            ,'Débit immédiat','CCHQ970212',NULL);
INSERT INTO Operation VALUES('OP03__-->LIVA860313','2016-12-05','Virement Permanent',100
                            ,'Débit immédiat','LIVA860313',NULL);
INSERT INTO Operation VALUES('OP04__CCHQ860313-->','2016-12-07','Picard', 100
                            ,'Débit différé','CCHQ860313','MC860313');
INSERT INTO Operation VALUES('OP05__-->CCHQ860313','2016-11-10','Remboursement Mutuelle', 200
                            ,'Crédit','CCHQ860313',NULL);
INSERT INTO Operation VALUES('OP06__CCHQ860313-->','2016-12-11','Retrait DAB Olivet', 100
                            ,'Débit immédiat','CCHQ860313','MC860313');
INSERT INTO Operation VALUES('OP07__CCHQ860313-->','2016-12-13','Retrait DAB St Cyr en Val', 200
                            ,'Débit immédiat','CCHQ860313','VS860313');
INSERT INTO Operation VALUES('OP08__CCHQ970212->','2016-12-02','Retrait DAB Olivet', 300
                            ,'Débit immédiat','CCHQ970212','VS970212');
INSERT INTO Operation VALUES('OP10__LIVA970212-->','2016-12-04','Retrait Guichet', 500
                            ,'Débit immédiat','LIVA970212',NULL);
INSERT INTO Operation VALUES('OP11__CCHQ860313->','2016-11-28','Retrait DAB St Cyr en Val', 900
                            ,'Débit immédiat','CCHQ860313','MC860313');
INSERT INTO Operation VALUES('OP13__-->CCHQ860313','2016-12-14','Chèque N° 3425678', 500
                            ,'Crédit','CCHQ860313',NULL);
INSERT INTO Operation VALUES('OP20__CCHQ860313-->','2016-12-08','Prélèvement EDF', 800
                            ,'Débit immédiat','CCHQ860313',NULL);
INSERT INTO Operation VALUES('OP21__CCHQ860313-->','2016-12-05','Auchan Olivet', 400
                            ,'Débit différé','CCHQ860313','MC860313');
INSERT INTO Operation VALUES('OP30__CCHQ921026-->','2016-12-03','Retrait DAB Orléans Sud', 300
                            ,'Débit immédiat','CCHQ921026','MC921026');
INSERT INTO Operation VALUES('OP31__CCHQ890101-->','2016-12-08','Virement Occasionnel', 300
                            ,'Débit immédiat','CCHQ890101',NULL);
INSERT INTO Operation VALUES('OP32__-->CCHQ860313','2016-12-09','Virement Occasionnel', 200
                            ,'Crédit','CCHQ860313',NULL);
INSERT INTO Operation VALUES('OP15__CCHQ860313-->','2016-12-09','SNCF Internet', 150
                            ,'Débit différé','CCHQ860313','MC860313');
INSERT INTO Operation VALUES('OP23__CCHQ860313-->','2016-11-25','SNCF Internet', 120
                            ,'Débit différé','CCHQ860313','MC860313');
INSERT INTO Operation VALUES('OP17__CCHQ860313-->','2016-12-11','Carrefour', 150
                            ,'Débit différé','CCHQ860313','VS860313');
