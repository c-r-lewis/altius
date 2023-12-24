CREATE TABLE Post(
   idPost INT AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   description VARCHAR(200),
   nbJaime INT NOT NULL,
   lienImage VARCHAR(100) NOT NULL,
   imageData LONGBLOB NOT NULL,
   PRIMARY KEY(idPost)
);

