DROP TABLE User;
CREATE TABLE User(
    login VARCHAR(50),
    email VARCHAR (50),
    region VARCHAR(70),
    motDePasse VARCHAR(256),
    statut VARCHAR(50),
    ville VARCHAR(80),
    numeroTelephone VARCHAR(50),
    nonce VARCHAR(8),
    PRIMARY KEY (login)
);

