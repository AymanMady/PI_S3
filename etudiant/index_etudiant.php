<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
include_once "../connexion.php";
include_once "nav_bar.php";
if(isset($_GET['id_semestre'])){
$id_semestre =$_GET['id_semestre'];
$_SESSION['id_sem']=$_GET['id_semestre'];
}
else{
    $id_semestre = $_SESSION['id_sem'];

}
$sql_etud = "SELECT * FROM etudiant WHERE email = '$email' ;";
$etud_qry = mysqli_query($conn, $sql_etud);
$row_etud = mysqli_fetch_assoc($etud_qry);

?>

    <style>
        .card-body:hover {
            cursor: pointer;
        }
    </style>
</head>

<body>
  
<div class="content-wrapper">
    <div class="content">

       <div class="page-header">
         <h3 class="page-title">
           <span class="page-title-icon bg-gradient-primary text-white me-2">
             <i class="mdi mdi-home"></i>
         </h3>
       </div>
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li></li>
                </ol>
            </div>
        </div>
        <div class="content">
                <div class="row">
                        <?php
                        $req_ens_mail =  "SELECT matiere.id_matiere,inscription.id_semestre,matiere.libelle,matiere.code,matiere.specialite
                         FROM inscription, matiere, etudiant WHERE inscription.id_etud=etudiant.id_etud AND inscription.id_matiere=matiere.id_matiere 
                         AND email = '$email'and inscription.id_semestre=$id_semestre";
                        $req = mysqli_query($conn, $req_ens_mail);
                        if (mysqli_num_rows($req) == 0) {
                            echo "Il n'y a pas encore de matières ajoutées !";
                        } else {
                          $i=0;
                          $list_colors = array('primary', 'info', 'success', 'secondary');        
                          while ($row = mysqli_fetch_assoc($req)) {
                      ?>
                      <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-<?php echo $list_colors[$i] ?> card-img-holder text-white">
                            <a href="soumission_etu_par_matiere.php?id_matiere=<?php echo $row['id_matiere']?>&color=<?php echo $list_colors[$i] ?>" style="text-decoration: none;" class="text-white">
                              <div class="card-body"  onclick="redirectToDetails(<?php echo $row['id_matiere'] ?>)" >
                              <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                <h3 class="mb-5"><?= $row['libelle'] ?> <?= $row['code'] ?></h3>
                                <h6 class="card-text"> filiere : <?= $row['specialite'] ?></h6>
                                <h3 class="card-text"> S<?= $row['id_semestre'] ?></h3>
                              </div>
                            </a>
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
</div>

       
  
    <script>
        function redirectToDetails(id_matiere,test) {
            window.location.href = "soumission_etu_par_matiere.php?id_matiere=" + id_matiere ;
        }
    </script>

