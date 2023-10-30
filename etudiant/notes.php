<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
include "../nav_bar.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <br><br><br>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="acceuil.php">Accueil</a></li>
                    <li>Les notes <?php //echo $nom_ens ?></li>
                </ol>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Code</th>
                    <th>Libellè de la matiére</th>
                    <th>Titre de la soumission</th>
                    <th>Note</th>
                </tr>
                <?php
                include_once "../connexion.php";
                $req_ens_mail =  "SELECT * FROM reponses, soumission, matiere,etudiant 
                WHERE reponses.id_etud=etudiant.id_etud AND
                 reponses.id_sous=soumission.id_sous AND 
                 soumission.id_matiere=matiere.id_matiere AND
                  email='$email' AND render = 1 ";
                $req = mysqli_query($conn, $req_ens_mail);
                if (mysqli_num_rows($req) == 0) {
                    echo "Il n'y a pas encore de matières ajoutées !";
                } else {
                    while ($row = mysqli_fetch_assoc($req)) {
                        ?>
                        <tr>
                            <td><?= $row['code'] ?></td>
                            <td><?= $row['libelle'] ?></td>
                            <td><?= $row['titre_sous'] ?></td>
                            <td><?= $row['note'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
