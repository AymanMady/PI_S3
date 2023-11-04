
<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="ens"){
    header("location:authentification.php");
    
}
?>
<?php
    include "nav_bar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailler matiere par enseignant </title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        ul li{
            list-style: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                <li>Détails sur la soumission  <?php //echo  ?> </li>
            </ol>
        </div>
 
    
                    <?php

                    include_once "../connexion.php";
                    $id_sous = $_GET['id_sous'];

                    $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere),enseignant WHERE id_sous = $id_sous and soumission.id_ens=enseignant.id_ens ";
                    $req = mysqli_query($conn , $req_detail);
                    while($row=mysqli_fetch_assoc($req)){
                    ?>
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p> <?php echo "<strong>Titre : </strong>". $row['titre_sous']; ?></p>
                    <p><?php echo "<strong>Description : </strong>". $row['description_sous'];  ?></p>
                    <p><?php echo "<strong>Pour plus des informations   : </strong>". $row['person_contact'];  ?></p>
                    <p><?php echo "<strong>Code de la matière : </strong>". $row['code']; ?></p>
                    <p> <?php echo "<strong>Date de  début : </strong>". $row['date_debut']; ?></p>
                    <p><?php echo "<strong>Date de  fin : </strong>" . $row['date_fin']; ?></p>
                    <p><?php echo "<strong>Nom et prénom de l'enseignant  : </strong>" . $row['nom']." ".$row['prenom']; ?></p>
                    
                  </div>
                </div>
              </div>
              <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-description">Le(s) Fichier(s)</h4>

                  <?php
                            $sql2 = "select * from fichiers_soumission where id_sous='$id_sous' ";
                            $req2 = mysqli_query($conn,$sql2);
                            if(mysqli_num_rows($req2) == 0){
                                echo "Il n'y a pas des fichier ajouter !" ;
                            }else {
                                ?>
                                 <ul>
                                <?php
                                while($row2=mysqli_fetch_assoc($req2)){
                                    $file_name = $row2['nom_fichier'];
                                    ?>
                                    <li><strong><?=$row2['nom_fichier']?></strong>
                                        <?php 
                                        $test=explode(".",$file_name);
                                        if( $test[1]=="pdf"){
                                        ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="open_file.php?file_name=<?=$file_name?>&id_sous=<?=$id_sous?>">Voir</a>
                                         <?php
                                            }
                                            else{
                                                ?>
                                                <a >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                                <?php 
                                                }
                                            
                                            ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="telecharger_fichier.php?file_name=<?=$file_name?>&id_sous=<?=$id_sous?>">Telecharger</a>

                                        </li>
                                    <br>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                            }
                        ?>
                  </div>
                </div>
              </div>
            <?php
            }
            ?>
        </div>
  
<?php
    if(isset($_GET['color']) ){
        $color = $_GET['color'];
        $id_matiere=$_GET['id_matiere'];
        ?>
        <p>
            <a href="soumission_par_matiere.php?id_matiere=<?php echo "$id_matiere"; ?>&color=<?php echo $color ?>" class="btn btn-primary">Retour</a>
        </p>
        <?php
    }else{
        ?>
        <p>
            <a href="soumission_en_ligne.php" class="btn btn-primary">Retour</a>
        </p>
        <?php
    }
?>

    </div>
</div>


</body>
</html>