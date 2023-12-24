<?php
namespace App\Altius\Controleur;

class ControleurUtilisateur extends ControleurGenerique
{

    public static function afficherDefaultPage()
    {
        // TODO: Modifier la redirection quand il y aura les connexions utilisateurs
        ControleurGeneral::afficherVue("connexion.html");
    }


    public static function uploadImage() {
        $uploadDirectory = 'assets/uploads/';

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_FILES['image'])) {
                $targetFile = $uploadDirectory . basename($_FILES['image']['name']);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if the file is an actual image
                if (getimagesize($_FILES['image']['tmp_name']) === false) {
                    echo 'File is not an image.';
                    $uploadOk = 0;
                }

                // Check file size (adjust as needed)
                if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                    echo 'Sorry, your file is too large.';
                    $uploadOk = 0;
                }

                // Allow only certain file formats (adjust as needed)
                $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageFileType, $allowedFormats)) {
                    echo 'Sorry, only JPG, JPEG, PNG, and GIF files are allowed.';
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo 'Sorry, your file was not uploaded.';
                } else {
                    // Move the file to the specified directory
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                        echo 'The file ' . basename($_FILES['image']['name']) . ' has been uploaded.';
                    } else {
                        echo 'Sorry, there was an error uploading your file.';
                    }
                }
            } else {
                echo 'No file uploaded.';
            }
        }

    }
}