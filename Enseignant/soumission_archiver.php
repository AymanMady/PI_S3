
<br><br><br>
<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:authentification.php");
 }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
 
<?php 
include "nav_bar.php";
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                
                   
            </ol>
        </div>
    </div>




<div style="overflow-x:auto;">
  <table class="table table-striped table-bordered">
          <tr>
              <th>Code</th>
              <th>Titre de soumission</th>
              <th>Date debut </th>
              <th>Date fin </th>
              <th>Actions</th>
          </tr>
          <?php 
              include_once "../connexion.php";
              $req_sous =  "SELECT DISTINCT soumission.*,matiere.* FROM soumission ,matiere,enseignant WHERE  soumission.id_ens=enseignant.id_ens AND soumission.id_matiere=matiere.id_matiere and  status = 2  and matiere.id_matiere IN (SELECT enseigner.id_matiere FROM enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and enseignant.email='$email')  ORDER BY date_fin DESC  ";
              $req = mysqli_query($conn , $req_sous);
              if(mysqli_num_rows($req) == 0){
                  echo "Il n'y a pas encore des soumission archiver !" ;
                  
              }else {
                  while($row=mysqli_fetch_assoc($req)){
                    ?>
                      <tr>
                          <td><?=$row['code']?></td>
                          <td><?=$row['titre_sous']?></td>
                          <td><?=$row['date_debut']?></td>
                          <td><?=$row['date_fin']?></td>
                          <td><a href="detail_soumission.php?id_sous=<?=$row['id_sous']?>">Detaille</a></td>
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
