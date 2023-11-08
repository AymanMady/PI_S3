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

include "nav_bar.php";
$id_sem=$_GET["id_semestre"];
?>

<style>
    /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
    tr:hover {
        cursor: pointer;
        background-color: aliceblue;
    }
</style>

<div class="container">

<div style="overflow-x:auto;"  >
    <div class="row">
            
          <?php 
          
              $req_ens_mail =  "SELECT matiere.*,semestre.* FROM matiere,enseigner,enseignant,semestre WHERE enseignant.id_ens=enseigner.id_ens and matiere.id_semestre=semestre.id_semestre and matiere.id_matiere=enseigner.id_matiere  and enseignant.email ='$email'and matiere.id_semestre=$id_sem";
              $i = 0;
              $list_colors = array("success","info","secondary","primary");
              $list_colors_hover = array("#24b2d016","#dfe9f7","#dfe9f7","#A35DFF0.15");

              $req = mysqli_query($conn , $req_ens_mail);

              if(mysqli_num_rows($req) == 0){
                  echo "Il n'y a pas encore des matiere ajouter !" ;
                  
              }else {
                  while($row=mysqli_fetch_assoc($req)){
                    ?>
                       
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-<?php echo $list_colors[$i]?> card-img-holder text-white">
 <!--                       l'id ma kan ymchi m3a le lien ga3          -->
                                <a href="soumission_par_matiere.php?id_matiere=<?php echo $row['id_matiere']?>&color=<?php echo $list_colors[$i] ?>&color_hover=<?php echo urlencode($list_colors_hover[$i])?>" style="text-decoration: none;" class="text-white">
                                <div class="card-body">
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="mb-5" onclick="redirectToDetails(<?php echo $row['id_matiere']; ?>)">
                                          <?=$row['libelle']?>
                                    </h4>
                                    <h6 class="card-text" onclick="redirectToDetails(<?php echo $row['id_matiere']; ?>)"><?=$row['specialite']?></h6>
                                </div>
                            </a>
                         </div>
                    </div> 
                        
                    <?php
                    if($i== 3){
                        $i = -1;
                      }
                    $i++;

                  }
              }
          ?>





    </div>
</div>

            

</div>
<script>
    function redirectToDetails(id_matiere) {
        // <?php $_SESSION['id_matirer']= $id_matiere ?>;
        window.location.href = "soumission_par_matiere.php?id_matiere=" + id_matiere;

    }
</script>
</body>
</html>
