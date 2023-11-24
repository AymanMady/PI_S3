<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
include "nav_bar.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <br><br><br>
    <br><br><br>


    <?php
    include_once "../connexion.php";
    $req_ens_mail =  "SELECT * FROM reponses, soumission, matiere,etudiant 
                WHERE reponses.id_etud=etudiant.id_etud AND
                 reponses.id_sous=soumission.id_sous AND 
                 soumission.id_matiere=matiere.id_matiere AND
                  email='$email' AND render = 1 ";
    $req = mysqli_query($conn, $req_ens_mail);


    $touto = "select * from etudiant where etudiant.email='$email' ";
    $req_tou = mysqli_query($conn, $touto);
    $row_tou = mysqli_fetch_assoc($req_tou);
    ?>


</body>

</html>
</br></br></br>
<div class="main-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    </li>
                    <li>Liste des note de l'etudiant &nbsp;<b> <a> <?php echo $row_tou['nom'] . " " . $row_tou['prenom']  ?></a> </b></li>
                </ol>
            </div>


            <div style="overflow-x:auto;">

                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Code matiére</th>
                        <th>Libellè de la matiére</th>
                        <th>Titre de la soumission</th>
                        <th>Note</th>
                    </tr>
                    <?php
                    if (mysqli_num_rows($req) == 0) {
                        echo "Il n'y a pas encore de dustribtion de note !";
                    } else {
                        while ($row = mysqli_fetch_assoc($req)) {
                    ?>
                            <tr>
                                <td>
                                    <?= $row['code'] ?></td>
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
    </div>
</div>
</body>