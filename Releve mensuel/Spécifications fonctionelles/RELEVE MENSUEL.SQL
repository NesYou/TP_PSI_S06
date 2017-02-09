DROP DATABASE IF EXISTS Releve_mensuel;

CREATE DATABASE IF NOT EXISTS Releve_mensuel;
USE Releve_mensuel;
# -----------------------------------------------------------------------------
#       TABLE : carteBancaire
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS carteBancaire
 (
   numCB VARCHAR(16)   ,
   numClient VARCHAR(6)   ,
   codeTypeCB VARCHAR(2)   ,
   numCompte VARCHAR(32)   ,
   dateExpiration DATE
   , PRIMARY KEY (numCB)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : compteCourant
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS compteCourant
 (
   numCompte VARCHAR(32)   ,
   decouvert DECIMAL(10,2)
   , PRIMARY KEY (numCompte)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : Mois
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Mois
 (
   Debut_Mois VARCHAR(32)
   , PRIMARY KEY (Debut_Mois)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : Operation
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Operation
 (
   codeOperation VARCHAR(30)   ,
   numCB VARCHAR(16)   ,
   numCompte VARCHAR(32)   ,
   dateOperation DATE   ,
   libelleOperation VARCHAR(32)   ,
   montantOperation DECIMAL(10,2)   ,
   typeOperation VARCHAR(32)
   , PRIMARY KEY (codeOperation)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : compteEpargne
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS compteEpargne
 (
   numCompte VARCHAR(32)   ,
   tauxInteret DECIMAL(4,2)   ,
   soldePlancher DECIMAL(10,2)
   , PRIMARY KEY (numCompte)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : typeCb
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS typeCb
 (
   codeTypeCB VARCHAR(2)   ,
   libelleTypeCB VARCHAR(32)
   , PRIMARY KEY (codeTypeCB)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : Client
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Client
 (
   numClient VARCHAR(6)   ,
   nomClient VARCHAR(32)   ,
   prenomClient VARCHAR(32)   ,
   adresse VARCHAR(128)   ,
   numTelephone VARCHAR(32)
   , PRIMARY KEY (numClient)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : Compte
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS Compte
 (
   numCompte VARCHAR(32)   ,
   numClient VARCHAR(6)   ,
   dateOuverture DATE   ,
   depotInitial DECIMAL(10,2)
   , PRIMARY KEY (numCompte)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : SoldeCCDebutMois
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SoldeCCDebutMois
 (
   Debut_Mois VARCHAR(32)   ,
   numCompte VARCHAR(32)   ,
   soldeAReporter DECIMAL(10,2)
   , PRIMARY KEY (Debut_Mois,numCompte)
 )
 comment = "";


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE carteBancaire
  ADD FOREIGN KEY FK_carteBancaireClient (numClient)
      REFERENCES Client (numClient) ;


ALTER TABLE carteBancaire
  ADD FOREIGN KEY FK_carteBancairetypeCb (codeTypeCB)
      REFERENCES typeCb (codeTypeCB) ;


ALTER TABLE carteBancaire
  ADD FOREIGN KEY FK_carteBancairecompteCourant (numCompte)
      REFERENCES compteCourant (numCompte) ;


ALTER TABLE compteCourant
  ADD FOREIGN KEY FK_compteCourantCompte (numCompte)
      REFERENCES Compte (numCompte) ;


ALTER TABLE Operation
  ADD FOREIGN KEY FK_OperationcarteBancaire (numCB)
      REFERENCES carteBancaire (numCB) ;


ALTER TABLE Operation
  ADD FOREIGN KEY FK_OperationCompte (numCompte)
      REFERENCES Compte (numCompte) ;


ALTER TABLE compteEpargne
  ADD FOREIGN KEY FK_compteEpargneCompte (numCompte)
      REFERENCES Compte (numCompte) ;


ALTER TABLE Compte
  ADD FOREIGN KEY FK_CompteClient (numClient)
      REFERENCES Client (numClient) ;


ALTER TABLE SoldeCCDebutMois
  ADD FOREIGN KEY FK_SoldeCCDebutMoisMois (Debut_Mois)
      REFERENCES Mois (Debut_Mois) ;


ALTER TABLE SoldeCCDebutMois
  ADD FOREIGN KEY FK_SoldeCCDebutMois_compteCourant (numCompte)
      REFERENCES compteCourant (numCompte) ;
