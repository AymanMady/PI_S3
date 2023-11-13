

<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="ens"){
    header("location:authentification.php");
}
?>
<style>
ul li{
    list-style: none;
}
</style>
<?php
    if(isset($_GET['id_rep'])){
        $id_rep=$_GET['id_rep'];
    }
    else{
        $id_rep = $_SESSION['id_rep'];
    }
    include "nav_bar.php";
    $req_detail="SELECT * FROM `reponses`,`etudiant`
            WHERE reponses.id_etud=etudiant.id_etud  and reponses.id_rep ='$id_rep'";
    $req = mysqli_query($conn , $req_detail);
    $row_nom=mysqli_fetch_assoc($req);
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailler matiere par enseignant </title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</head>
<body>

<div class="container">
    <div class="row">
            <ol class="breadcrumb">
                </li>
                <li>Consultation de réponse de l'etudiant  <b><a> <?php echo $row_nom['nom']." " .$row_nom['prenom']?> </a></b></li> 
            </ol>
                <?php
                $req_detail = "SELECT * FROM reponses inner join etudiant using(id_etud) WHERE id_rep = $id_rep  ";
                $req = mysqli_query($conn , $req_detail);
                while($row=mysqli_fetch_assoc($req)){
                    ?>
                
                <div class="col-md-5 grid-margin">
                    <div class="card">
                        <div class="card-body">
                                <h4>
                                    <p><?php echo "<strong>Matricule : </strong>". $row['matricule']; ?></p>
                                    <p><?php echo "<strong>Nom et prenom de l'etudiant  : </strong>" . $row['nom']." ".$row['prenom']; ?></p>
                                    <p><?php echo "<strong>Description : </strong>". $row['description_rep'];  ?></p>
                                    <p><?php echo "<strong>Date : </strong>". $row['date']; ?></p>
                                </h4> 
                        </div>
                    </div>
                </div>


            <?php
                }

                $req_detail = "SELECT reponses.* FROM reponses inner join etudiant using(id_etud) WHERE id_rep = $id_rep  ";
                $req = mysqli_query($conn , $req_detail);
                $row=mysqli_fetch_assoc($req)
            ?>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <h4 class="card-description">Le(s) Fichier(s)</h4>

                  <?php
                        $sql2 = "select * from fichiers_reponses where id_rep='$id_rep' ";
                        $req2 = mysqli_query($conn,$sql2);
                            if(mysqli_num_rows($req2) == 0){
                                echo "Il n'y a pas des fichier ajouter !" ;
                            }else {
                                ?>
                                 <ul>
                                <?php
                                while($row2=mysqli_fetch_assoc($req2)){
                                    $file_name = $row2['nom_fichiere'];
                                    ?>
                                    <li><strong><?=$file_name?></strong>
                                        <?php 
                                        $test=explode(".",$file_name);
                                        if( $test[1]=="pdf"){
                                        ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="open_file.php?file_name=<?=$file_name?>&id_sous=<?=$id_rep?>">Voir</a>
                                         <?php
                                            }
                                            else{
                                                ?>
                                                <a >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                                <?php 
                                                }
                                            
                                            ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="telecharger_fichier.php?file_name=<?=$file_name?>&id_sous=<?=$id_rep?>">Telecharger</a>

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



              <div class="col-md-2 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            
                        <h4 class="text-center" style='font-size: 20px;'><strong>Note</strong></h4>
                        <?php
                        if($row['note']!=NULL){
                        echo "<center><b style='font-size: 20px;'>".$row['note']." /20</b></center>" ;
                        }
                        ?>
                        <?php
                        $sql3 = "select * from reponses where id_rep='$id_rep' ";
                        $req3 = mysqli_query($conn,$sql3);
                        $row3= mysqli_fetch_assoc($req3);
                        if($row3['note']>0){
                        ?>
                        <a href="affecte_une_note.php?id_etud=<?= $id_rep?>"  class="btn btn-primary p-1 mt-2">Modifier</a>
                        <?php
                        }else{
                        ?>
                        <a href="affecte_une_note.php?id_etud=<?= $id_rep?>"  class="btn btn-primary p-1 mt-2">Noter</a>
                        <?php
                        }
                        ?>
                    </div>
                                
                                
                        </div>
                </div>


            <div style="display: flex ; justify-content: space-between;">
            <div>
            <a href="reponses_etud.php?id_sous=<?=$row['id_sous']?>" class="btn btn-primary">Retour</a>
            </div>
            </div>
            </div>
    </div>
</body>
</html>
