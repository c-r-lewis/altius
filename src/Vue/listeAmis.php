<!DOCTYPE html>
<html>
<head>
    <title>Liste d'amis</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/listeAmis.css">
</head>
<body>
<?php
use App\Altius\Modele\DataObject\Friends;
?>
    <h1>Liste d'amis</h1>
    <ul>
        <?php
            foreach($listeAmis as $ami) {
                echo "<li>$ami</li>";
            }
        ?>
    </ul>
</body>
</html>