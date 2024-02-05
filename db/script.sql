DROP TABLE User;
CREATE TABLE User(
    idUser INT AUTO_INCREMENT,
    login VARCHAR(50),
    email VARCHAR (50),
    region VARCHAR(70),
    motDePasse VARCHAR(256),
    statut VARCHAR(50),
    ville VARCHAR(80),
    numeroTelephone VARCHAR(50),
    nonce VARCHAR(8),
    estSuppr INT,
    PRIMARY KEY (idUser)
);

DELIMITER //

CREATE OR REPLACE FUNCTION loginEstUtiliser (p_login VARCHAR(50)) RETURNS INT
Begin
    DECLARE v_nbLogin INT;
    DECLARE  v_estPasSuppr INT;

    SELECT COUNT(login) INTO v_nbLogin FROM User WHERE login = p_login;

    if v_nbLogin<=0 THEN
        RETURN 0;
    else
        SET v_estPasSuppr = 0;
        FOR v_suppr IN (SELECT estSuppr FROM User WHERE login = p_login) DO
            if v_suppr.estSuppr = 0 THEN
                SET v_estPasSuppr = v_estPasSuppr+1;
            end if;
        END FOR ;
        if v_estPasSuppr<=0 THEN
            RETURN 0;
        else
            RETURN 1;
        end if;
    end if;
end//

CREATE OR REPLACE PROCEDURE ajouterUser(p_idUser INT, p_login VARCHAR(50),p_email VARCHAR(50),p_region VARCHAR(50),p_motDePasse VARCHAR(256),
p_statut VARCHAR(50),p_ville VARCHAR (50), p_numeroTelephone VARCHAR (50),p_nonce VARCHAR(50),p_estSuppr INT)
BEGIN
INSERT INTO User (login, email, region, motDePasse, statut, ville, numeroTelephone, nonce,estSuppr) VALUES (p_login,p_email,p_region,p_motDePasse,
                                                                                                            p_statut,p_ville,p_numeroTelephone,p_nonce,p_estSuppr);
end //