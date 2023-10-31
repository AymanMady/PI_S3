<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:../authentification.php");
 }

 include_once "../connexion.php";

$sql_ens = "SELECT * FROM enseignant WHERE enseignant.email ='$email'";
$req_ens = mysqli_query($conn , $sql_ens);
$row_ens = mysqli_fetch_assoc($req_ens);

if(!empty($_GET['id_etud']) and !empty($_GET['id_sous'])){
  $id_etud = $_GET['id_etud'];
  $id_sous = $_GET['id_sous'];
}

if(isset($_POST['button'])){
  if( !empty($_POST['id_etud']) && !empty($_POST['id_sous'])) {
    $id_etud = $_POST['id_etud'];
    $id_sous = $_POST['id_sous'];
  
    $req = mysqli_query($conn, "UPDATE demande SET  autoriser = 1  WHERE  id_etud = $id_etud and id_sous = $id_sous ");
    
    if($req){
        echo "<script>window.location.href='detail_message.php?id_sous=".$id_sous."&id_etud=".$id_etud.";</script>";
    }else {
        $message = "erreur";
    }
  
  }
}  

if(isset($_POST['annuler'])){
  if( !empty($_POST['id_etud']) && !empty($_POST['id_sous'])) {
    $id_etud = $_POST['id_etud'];
    $id_sous = $_POST['id_sous'];
  
    $req = mysqli_query($conn, "UPDATE demande SET  autoriser = 0  WHERE  id_etud = $id_etud and id_sous = $id_sous ");
    
    if($req){
      echo "<script>window.location.href='detail_message.php?id_sous=".$id_sous."&id_etud=".$id_etud.";</script>";
    }else {
        $message = "erreur";
    }
  
  }
}  

include "nav_bar.php";
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="row">
          <div class="col-md-9 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4>  </h4>
                    <br>
                    <?php
                          $req2 = mysqli_query($conn, "SELECT autoriser,nom,prenom,titre_sous,matricule,`description` FROM demande ,soumission,etudiant where soumission.id_sous=demande.id_sous and etudiant.id_etud = demande.id_etud and demande.id_sous = $id_sous and demande.id_etud = $id_etud ;");
                          $row2 = mysqli_fetch_assoc($req2);
                    ?>
                    <h4 class="font-weight-normal mb-3">
                            <?php echo "<strong class='font-weight-bold'><p>Matricule de l'etudiant : ". $row2['matricule'] ."</p></strong>" ?>
                            <?php echo "<strong class='font-weight-bold'><p>Titre de la soumission : </strong>". $row2['titre_sous']."</p></strong>" ?>
                            <?php echo "<strong class='font-weight-bold'><p>Description : </strong>". $row2['description']."</p></strong>" ?>
                    </h4>
                  
                    <form action="" method="POST" class="forms-sample">
                      <input type="text" name="id_sous" style="display:None;" value="<?=$id_sous?>">
                      <input type="text" name="id_etud" style="display:None;" value="<?=$id_etud?>">
                      <div style="display: flex;justify-content: space-bettwen;">

                      <?php 
                        if( $row2['autoriser'] == 0 ){
                          ?>
                          <button type="submit" name="button" class="btn btn-gradient-primary me-2">Autorisez a modifier</button>
                          <?php  
                        }else{
                          ?>
                            <button type="submit" name="annuler" class="btn btn-gradient-primary me-2">Annuler l'autorisation</button>
                          <?php
                        }
                      ?>
                      
                      <a href="" class="btn btn-light">Annuler</a>
                      
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>