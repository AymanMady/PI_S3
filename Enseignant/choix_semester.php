<?php 
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="ens"){
    header("location:../authentification.php");
}

include "nav_bar.php";
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

$i = 0;
$n=1;
                  while($n!=7){
                   
                              $list_colors = array("success","info","secondary","primary");
                              $list_colors_hover = array("#24b2d016","#dfe9f7","#dfe9f7","rgba(163, 93, 255, 0.15)");
                    ?>
                       
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-<?php echo $list_colors[$i]?> card-img-holder text-white">
 <!--                       l'id ma kan ymchi m3a le lien ga3          -->
                            <a href="index_enseignant.php?id_semestre=<?php echo $n; ?>" style="text-decoration: none;" class="text-white">
                                <div class="card-body" onclick="redirectToDetails(<?php echo $n; ?>)">
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    
                                    <h1 class="card-text" onclick="redirectToDetails(<?php echo $n ?>)"><?="S"."$n"?></h1>
                                    <h4 class="mb-5" onclick="redirectToDetails(<?php echo $n; ?>)">
                                     
                                    </h4>
                                </div>
                            </a>
                         </div>
                    </div> 
                        
                    <?php
                    if($i== 3){
                        $i = 0;
                      }
                    
                      $n++;
                    $i++;
                  
                    }
            ?>
            <script>
    function redirectToDetails(id_semester) {
        // <?php $_SESSION['id_semestre']= $id_semester ?>;
        window.location.href = "index_enseignant.php?id_semestre=" + id_semester;

    }
</script>
         