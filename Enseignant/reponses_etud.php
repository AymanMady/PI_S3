<br>
<?php

 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:../authentification.php");
 }
 include_once "../connexion.php";
    $id_sous = $_GET['id_sous'];
    if(isset($_POST['sou'])){
        $sql="UPDATE reponses set render=1 WHERE id_sous='$id_sous'";
        mysqli_query($conn,$sql);
    }
    $sql_affichage =  "SELECT * from reponses,etudiant where reponses.id_sous='$id_sous' AND reponses.id_etud=etudiant.id_etud;";

    $req_affichage = mysqli_query($conn , $sql_affichage);
    include "nav_bar.php";


    

        

        ?>

        

<?php
        $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere),enseignant WHERE id_sous = $id_sous and soumission.id_ens=enseignant.id_ens ";
        $req = mysqli_query($conn , $req_detail);
        $row=mysqli_fetch_assoc($req);
        $sql1 = "select count(*) as num_rep from reponses where id_sous = $id_sous ";
        $req1 = mysqli_query($conn , $sql1);
        $row1=mysqli_fetch_assoc($req1);
    
        $sql2 = "select count(*) as num_insc from  inscription,matiere,soumission where inscription.id_matiere=matiere.id_matiere and matiere.id_matiere=soumission.id_matiere and  id_sous = $id_sous; ";
        $req2 = mysqli_query($conn , $sql2);
        $row2=mysqli_fetch_assoc($req2);
?>
<style>
    .submission-div {
        display: flex;
        align-items: center;
        height: 200px;
    }

    .description { 
        flex: 1;
        padding-right: 100px;
        background-color: aliceblue;
        min-height: 100%;
    }

    .response-count {
        width: 200px;
        margin-left: 10px;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        border-radius: 5px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .nbr_etud {
        font-size: 50px;
    }
    .descri {
        text-align: center;
        font-size: 25px;
        font-weight: bold;
    }
    .descri_contenu{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-left: 15px;
    }
</style>

<div class="container">
    <div class="row">


        <div class="col-md-9 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center">Description de la soumission</h4><br>
                        <div class="row">
                            <div class="col-md-6">
                            <p class=" "> <?php echo "<strong>Titre :&nbsp; </strong>". $row['titre_sous']; ?></p>
                            <p class=""><?php echo "<strong>Description :&nbsp; </strong>". $row['description_sous'];  ?></p>
                            <p class=""> <?php echo "<strong>Code de la matière :&nbsp; </strong>". $row['code']; ?></p>
                            </div>

                            <div class="col-md-6">
                            <p class=""> <?php echo "<strong>Date de  début : &nbsp;</strong>". $row['date_debut']; ?></p>
                            <p class=""><?php echo "<strong>Date de  fin :&nbsp; </strong>" . $row['date_fin']; ?></p>
                            <p class=""> <?php echo "<strong>l'enseignant   :&nbsp; </strong>" . $row['nom']." ".$row['prenom']; ?></p>

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
                            <p class="card-text display-2"><?php echo $row1['num_rep']."/".$row2['num_insc']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<?php     if(mysqli_num_rows($req_affichage) > 0){
?>
    <div class="card-body" style="display: flex ; justify-content: space-between;">
    <div>
    <a href="list_etudiant.php?id_matiere=<?=$row['id_matiere']?>" class = "btn btn-gradient-primary" >List des etudiant s'inscrire</a>
    </div>
    <div>
    <form action="" method="POST">
        <input type="submit" class="btn btn-gradient-primary ml-25" value="Envoie les Notes" name="sou">
    </form>
    </div>
    </div>
<?php }

?>
<div style="overflow-x:auto;"  >
  <table class="table table-striped table-bordered table-hover">
        
          <?php 
             
              if(mysqli_num_rows($req_affichage) == 0){
                  echo "<h4>Il n'y a pas encore des reponses ajouter !</h4><br>" ;
                  
              }else {?>
                <tr>
                <th>Matricule</th>
                <th>Description de la reponse</th>
                <th>Date</th>
                <th>Details</th>
            </tr>
            <?php
                  while($row=mysqli_fetch_assoc($req_affichage)){
                    ?>
                      <tr>
                          <td><?=$row['matricule']?></td>
                          <td><?=$row['description_rep']?></td>
                          <td><?=$row['date']?></td>
                          <td><a href="consiltation_de_reponse.php?id_rep=<?=$row['id_rep']?>">Consilter</Details></a></td>
                      </tr>
                    <?php
                  }
              }
          ?>
        </table>
     </div>
    </div>
</div>
</body>
</html>
