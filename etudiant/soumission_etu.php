<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="etudiant"){
     header("location:../authentification.php");
 }


    include "nav_bar.php";

    
?>


<title>Detailler matiere par enseignant </title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../JS/sweetalert2.js"></script>


<div class="content-wrapper">

<div class="container">
    <div class="row">
    <?php
    include_once "../connexion.php";
    if(!empty($_GET['id_sous'])){
        $id_sous = $_GET['id_sous'];
    }else{
        $id_sous= $_SESSION['id_sous'];
    }

    $req_detail = "SELECT * FROM soumission  WHERE id_sous = $id_sous and (status=0 or status=1)  ";
    $req = mysqli_query($conn , $req_detail);
    mysqli_num_rows($req);

    while($row=mysqli_fetch_assoc($req)){
    ?>     
    <div class="col-md-5 grid-margin">
    <div class="card">
        <div class="card-body">
            
            <h4>
            <p><?php echo "<strong>Titre : </strong>". $row['titre_sous']; ?></p>
            <p><?php echo "<strong>Description : </strong>". $row['description_sous'];  ?></p>
            <p><?php echo "<strong>Pour plus des informations   : </strong>". $row['person_contact'];  ?></p>
            <p><?php echo "<strong>Date de  début : </strong>". $row['date_debut']; ?></p>
            <p><?php echo "<strong>Date de  fin : </strong>" . $row['date_fin']; ?></p>
            </h4>
                
        </div>
    </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-description">Le(s) Fichier(s) : </h4>
                <?php
                    $sql2 = "select * from fichiers_soumission where id_sous='$id_sous' ";
                    $req2 = mysqli_query($conn,$sql2);
                    if(mysqli_num_rows($req2) == 0){
                    ?>
                    <ul style="list-style: none;">
                    <?php
                    echo "Il n'y a pas des fichier ajouter !" ;
                    ?>
                <?php
                }else {
                    while($row2=mysqli_fetch_assoc($req2)){
                        $file_name=$row2['nom_fichier'];
                        ?>
                            <li  style="list-style: none;">
                        <strong><?= $file_name ?> </strong>
                        
                        <?php 
                        $test=explode(".",$file_name);
                        if( $test[1]=="pdf"){
                        ?>
                        <a href="open_file.php?file_name=<?=$file_name?>&id_sous=<?=$id_sous?>" style="text-decoration: none;" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voir</a>
                        <?php 
                        }
                        else{
                            ?>
                            <a >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Voir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            <?php 
                            }
                        
                        ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="telecharger_fichier.php?file_name=<?=$file_name?>&id_sous=<?=$id_sous?>" style="text-decoration: none;">Telecharger</a>
                        </li>
                        <br>
                        <?php
                    }
                }
            ?>
            </ul>
            <?php
            $id_sous= $row['id_sous'];
                }
                $sql17 = "select * from reponses where id_sous = '$id_sous' and id_etud = (select id_etud from etudiant where email = '$email') AND render = 1 ";
                $req17 = mysqli_query($conn,$sql17);
                if(mysqli_num_rows($req17)){
                $row17=mysqli_fetch_assoc($req17)
                ?>
                <h3> 
                    Note =  <?php echo $row17['note']     ?> 
                </h3>
                <?php if( $row17['note'] > 0 ){    ?>
                <a href= "reclemation.php" class="btn btn-primary">Reclemation</a>
                <?php  
                }
                }
                ?>
            </div>
        </div>
    </div>
    <?php  
    $req_detail = "SELECT `status`, `date_fin`   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)    ";
    $req11 = mysqli_query($conn , $req_detail);
    $row12=mysqli_fetch_assoc($req11);
    $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
    $req3 = mysqli_query($conn , $req_detail3);
    $sql = "select * from reponses where id_sous = '$id_sous' and id_etud = (select id_etud from etudiant where email = '$email') ";
    $req = mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($req);
    $req_detail2 = "SELECT  `autoriser`  FROM soumission , demande  WHERE soumission.id_sous = $id_sous and (status=0 or status=1)  and soumission.id_sous = demande.id_sous and demande.id_etud = (select id_etud from etudiant where email = '$email') and autoriser = 1 ";
    $req2 = mysqli_query($conn , $req_detail2);
    $row2=mysqli_fetch_assoc($req2);

      if(   mysqli_num_rows($req3) > 0 ){
        if(mysqli_num_rows($req2) == 0 or $row2['autoriser'] == 0 ){
            if (mysqli_num_rows($req) == 0   ) {
                $_SESSION['autorisation'] = true;
                ?>
                <p>
                    <a href="reponse_etudiant.php?id_sous=<?=$id_sous?>" class="btn btn-primary">Rendre le travail</a>
                </p>
                <?php
            }else{
                ?>
                    <?php
                    if($row['confirmer'] ==  1){
                    ?>
                        <p>
                            <a href="demande_modifier.php?id_sous=<?=$id_sous?>" class="btn btn-primary">Demande de faire une modification</a>
                        </p>
                    <?php
                    }else{
                        $_SESSION['autorisation'] = true;
                    ?>
                        <p>
                            <a href="reponse_etudiant.php?id_sous=<?=$id_sous?>" class="btn btn-primary">Modifier le travail</a>
                        </p>
                    <?php
                }
            }
        }else{
            if (mysqli_num_rows($req) == 0   ) {
                $_SESSION['autorisation'] = true;
                ?>
                <p>
                    <a href="reponse_etudiant.php?id_sous=<?=$id_sous?>" class="btn btn-primary">Rendre le travail</a>
                </p>
                <?php
            }else{
                ?>
                    <?php
                    if($row['confirmer'] ==  1){
                    ?>
                        <p>
                            <a href="demande_modifier.php?id_sous=<?=$id_sous?>" class="btn btn-primary">Demande de faire une modification</a>
                        </p>
                    <?php
                    }else{
                        $_SESSION['autorisation'] = true;
                    ?>
                        <p>
                            <a href="reponse_etudiant.php?id_sous=<?=$id_sous?>" class="btn btn-primary">Modifier le travail</a>
                        </p>
                    <?php
                }
            }
        }
     }


  ?>
</div>
<?php
if (isset($_SESSION['ajout_reussi']) && $_SESSION['ajout_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Ajout réussi !',
        text: 'La réponse a été ajouté avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";
    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['ajout_reussi']);
  }


?>


<?php
if (isset($_SESSION['demande_reussi']) && $_SESSION['demande_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Démande réussi !',
        text: 'La démande a été envoyer avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";
  
    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['demande_reussi']);
  }
  

?>
         </div>
      </div>
    </div>
  </div>
</div>
