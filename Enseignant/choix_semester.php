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



$req="SELECT DISTINCT id_semestre FROM matiere, enseigner, enseignant 
WHERE matiere.id_matiere = enseigner.id_matiere AND
enseigner.id_ens = enseignant.id_ens AND email='$email' order by id_semestre";       



$query=mysqli_query($conn,$req);
if ($query ) { 

    while($row=mysqli_fetch_assoc($query)){
                   
                              $list_colors = array("success","info","secondary","primary");
                              $list_colors_hover = array("#24b2d016","#dfe9f7","#dfe9f7","rgba(163, 93, 255, 0.15)");
                    ?>
                       
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-<?php echo $list_colors[$i]?> card-img-holder text-white">
 <!--                       l'id ma kan ymchi m3a le lien ga3          -->
                            <a href="index_enseignant.php?id_semestre=<?php echo $row['id_semestre']; ?>" style="text-decoration: none;" class="text-white">
                                <div class="card-body" onclick="redirectToDetails(<?php echo $row['id_semestre']; ?>)">
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="mb-5" onclick="redirectToDetails(<?php echo $row['id_semestre']; ?>)">
                                     La Soumissions du Semestre  :
                                    </h4>
                                    <h1 class="card-text" onclick="redirectToDetails(<?php echo $row['id_semestre'] ?>)"><?="S".$row['id_semestre']?></h1>
                                </div>
                            </a>
                         </div>
                    </div> 
                        
                    <?php
                    if($i== 3){
                        $i = 0;
                      }
                    
                    $i++;
                  
                    }}
            ?>
            <script>
    function redirectToDetails(id_semester) {
        // <?php $_SESSION['id_semestre']= $id_semester ?>;
        window.location.href = "index_enseignant.php?id_semestre=" + id_semester;

    }
</script>
         