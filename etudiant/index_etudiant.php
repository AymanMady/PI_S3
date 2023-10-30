<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}

include_once "../connexion.php";
include_once "nav_bar.php";
$sql_etud = "SELECT * FROM etudiant WHERE email = '$email' ;";
$etud_qry = mysqli_query($conn, $sql_etud);
$row_etud = mysqli_fetch_assoc($etud_qry);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        .card-body:hover {
            cursor: pointer;
        }

       
    </style>
</head>

<body>
  
 

   <!-- partiel -->
   <div class="main-panel">
     <div class="content-wrapper">
       <div class="page-header">
         <h3 class="page-title">
           <span class="page-title-icon bg-gradient-primary text-white me-2">
             <i class="mdi mdi-home"></i>
           </span>   Les matières inscrites par l'étudiant &nbsp;&nbsp;<a> <?php echo $row_etud['nom']." ".$row_etud['prenom'] ?> </a>
         </h3>
       </div>
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                  
                    <li></li>
                </ol>
            </div>
        </div>
        <div class="container">
<div class="b-example-divider"></div>

        <div style="overflow-x:auto;">
          
        <div class="row">
                <?php
                
                $req_ens_mail =  "SELECT * FROM inscription, matiere, etudiant WHERE inscription.id_etud=etudiant.id_etud AND inscription.id_matiere=matiere.id_matiere AND email = '$email'";
                $req = mysqli_query($conn, $req_ens_mail);
                if (mysqli_num_rows($req) == 0) {
                    echo "Il n'y a pas encore de matières ajoutées !";
                } else {
                  $i=0;
                  $list_colors = array('primary', 'info', 'success', 'warning');
                              
                    while ($row = mysqli_fetch_assoc($req)) {
                        ?>
                    
                     
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-<?php echo $list_colors[$i] ?> card-img-holder text-white">
                  
                  <div class="card-body"  onclick="redirectToDetails(<?php echo $row['id_matiere'] ?>)" >
                    <h3 class="mb-5"><?= $row['libelle'] ?>            <?= $row['code'] ?></h3>
                    <h6 class="card-text"> filiere : <?= $row['specialite'] ?></h6>
                  </div>
                  <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
            </div>
          </footer>
                </div>
              </div>
   
                <?php
                   if ($i ==3){
                     
                    $i=-1;
                   }
                     
                   $i++;  
                    }

                }
                ?>
             </div>
        </div>
        </div>
       
  <br>

  
    <script>
        function redirectToDetails(id_matiere,test) {
            window.location.href = "soumission_etu_par_matiere.php?id_matiere=" + id_matiere ;
        }
    </script>
  
</body>

</html>
