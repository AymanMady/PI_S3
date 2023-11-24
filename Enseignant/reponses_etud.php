<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location:../authentification.php");
}
include_once "../connexion.php";
$id_sous = $_GET['id_sous'];
if (isset($_POST['sou'])) {
    $sql = "UPDATE reponses SET render=1 WHERE id_sous='$id_sous'";
    mysqli_query($conn, $sql);
}
$sql_affichage = "SELECT * FROM reponses, etudiant WHERE reponses.id_sous='$id_sous' AND reponses.id_etud=etudiant.id_etud;";

$req_affichage = mysqli_query($conn, $sql_affichage);
include "nav_bar.php";
?>

<?php
$req_detail = "SELECT * FROM soumission INNER JOIN matiere USING(id_matiere), enseignant WHERE id_sous = $id_sous AND soumission.id_ens=enseignant.id_ens ";
$req = mysqli_query($conn, $req_detail);
$row = mysqli_fetch_assoc($req);
$sql1 = "SELECT COUNT(*) as num_rep FROM reponses WHERE id_sous = $id_sous ";
$req1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($req1);

$sql2 = "SELECT COUNT(*) as num_insc FROM inscription, matiere, soumission WHERE inscription.id_matiere=matiere.id_matiere and matiere.id_matiere=soumission.id_matiere and id_sous = $id_sous; ";
$req2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($req2);
?>


<div class="container pt-4">
    <div class="row">

        <div class="col-md-9 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Description de la soumission</h4><br>
                    <div class="row">
                        <div class="col-md-6">
                            <p class=" "> <?php echo "<strong>Titre :&nbsp; </strong>" . $row['titre_sous']; ?></p>
                            <p class=""><?php echo "<strong>Description :&nbsp; </strong>" . $row['description_sous']; ?></p>
                            <p class=""> <?php echo "<strong>Code de la matière :&nbsp; </strong>" . $row['code']; ?></p>
                        </div>

                        <div class="col-md-6">
                            <p class=""> <?php echo "<strong>Date de début : &nbsp;</strong>" . $row['date_debut']; ?></p>
                            <p class=""><?php echo "<strong>Date de fin :&nbsp; </strong>" . $row['date_fin']; ?></p>
                            <p class=""> <?php echo "<strong>Enseignant :&nbsp; </strong>" . $row['nom'] . " " . $row['prenom']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-description">Nombre d'étudiants ayant répondu</h4>
                    <div class="media">
                        <div class="media-body">
                            <center><p class="card-text display-3"><?php echo $row1['num_rep'] . "/" . $row2['num_insc']; ?></p></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (mysqli_num_rows($req_affichage) > 0) { ?>
            <div class="card-body" style="display: flex ; justify-content: space-between;">
                <div>
                    <a href="list_etudiant.php?id_matiere=<?= $row['id_matiere'] ?>" class="btn btn-gradient-primary">Liste des étudiants inscrits</a>
                </div>
                <div>
                    <form action="" method="POST">
                        <input type="submit" class="btn btn-gradient-primary ml-25" value="Envoyer les Notes" name="sou">
                    </form>
                </div>
            </div>
        <?php
        }

        $req_detail = "SELECT soumission.id_sous ,etudiant.id_etud ,matricule,nom,prenom FROM soumission,etudiant,inscription WHERE   soumission.id_matiere = inscription.id_matiere and etudiant.id_etud = inscription.id_etud and soumission.id_sous = $id_sous;";
        $req = mysqli_query($conn, $req_detail);
        ?>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Les réponses des étudiants  :</h4>
                        <table id="example" class="table table-bordered" style="width:100%">
                            <tr>
                                <th>Matricule</th>
                                <th>Nom et prénom</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Détails</th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($req)) {
                                $id_sous = $row['id_sous'];
                                $id_etud = $row['id_etud'];
                                $req_detail2 = "SELECT * FROM reponses WHERE  id_sous = $id_sous and id_etud = $id_etud";
                                $req2 = mysqli_query($conn, $req_detail2);
                                if (mysqli_num_rows($req2) > 0) {
                                    $row2 = mysqli_fetch_assoc($req2);
                                    $status = ($row2['confirmer'] == 1) ? "<label class='badge badge-success'>Confirmé<label>" : "<label class='badge badge-warning'>Non-confirmé<label>";
                            ?>
                                <tr <?php if ($row2['confirmer'] == 1) { ?> class="table-success" <?php } else { ?> class="table-warning" <?php } ?>>
                                    <td><?php echo $row['matricule'] ?></td>
                                    <td><?php echo $row['nom']; echo $row['prenom'] ?></td>
                                    <td><?php echo $row2['date'] ?></td>
                                    <td><?php echo $status ?></td>
                                    <td><a style="text-decoration:None" href="consiltation_de_reponse.php?id_rep=<?php echo $row2['id_rep']; ?>">Consulter</a></td>
                                </tr>
                            <?php
                                }
                            }
                            $req_detail = "SELECT soumission.id_sous ,etudiant.id_etud ,matricule,nom,prenom FROM soumission,etudiant,inscription WHERE   soumission.id_matiere = inscription.id_matiere and etudiant.id_etud = inscription.id_etud and soumission.id_sous = $id_sous;";
                            $req = mysqli_query($conn, $req_detail);
                            while ($row = mysqli_fetch_assoc($req)) {
                                $id_sous = $row['id_sous'];
                                $id_etud = $row['id_etud'];
                                $req_detail2 = "SELECT * FROM reponses WHERE  id_sous = $id_sous and id_etud = $id_etud";
                                $req2 = mysqli_query($conn, $req_detail2);
                                if (mysqli_num_rows($req2) == 0) {
                            ?>
                                <tr class="table-danger">
                                    <td><?php echo $row['matricule'] ?></td>
                                    <td><?php echo $row['nom']." ".$row['prenom']?></td>
                                    <td></td>
                                    <td><label class="badge badge-danger">En attente</label></td>
                                    <td></td>
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
    </div>
</div>
