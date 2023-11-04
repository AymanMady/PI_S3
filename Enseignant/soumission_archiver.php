<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:authentification.php");
 }

include "nav_bar.php";

$req_sous =  "SELECT DISTINCT soumission.*,matiere.* FROM soumission ,matiere,enseignant WHERE  soumission.id_ens=enseignant.id_ens AND soumission.id_matiere=matiere.id_matiere and  status = 2  and matiere.id_matiere IN (SELECT enseigner.id_matiere FROM enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and enseignant.email='$email')  ORDER BY date_fin DESC  ";
$req = mysqli_query($conn , $req_sous);
?>

<div class="page-header">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Soumission archiver :</h4>
                    <br>
                    <table id="example" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                            <th>Code</th>
                                <th>Titre de soumission</th>
                                <th>Date debut </th>
                                <th>Date fin </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while($row=mysqli_fetch_assoc($req)){
                                ?>
                                <tr>
                                    <td><?php echo $row['code']?></td>
                                    <td><?php echo $row['titre_sous']?></td>
                                    <td><?php echo $row['date_debut']?></td>
                                    <td><?php echo $row['date_fin']?></td>
                                    <td><a href="detail_soumission.php?id_sous=<?=$row['id_sous']?>">Detaille</a></td>
                                </tr>
                            <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
