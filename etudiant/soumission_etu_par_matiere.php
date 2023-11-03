<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}

include_once "nav_bar.php";
include_once "../connexion.php";
$id_matiere = $_GET['id_matiere'];
$sql1="select * from matiere where id_matiere=$id_matiere";
$sql2 = mysqli_query($conn , $sql1);
$row1 =  mysqli_fetch_assoc($sql2);

$color = $_GET['color'];

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <style>
        /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
        #tou:hover {
            cursor: pointer;
            background-color: aliceblue;
        }
    </style>
</head>

<body>
   
   
   
       
     <style>
              .div-hover:hover {
      background-color: #dfe9f7;
      cursor: pointer; /* Changer le curseur de la souris */
    }
    .div-hover{
      border: 1px solid rgb(209, 206, 206);
      border-radius: 5px;
    }

    </style>

  </head>
  <body>
 
      <!-- partial:partials/_navbar.html -->
      
 
  
        <div class="main-panel">
          <div class="content-wrapper">
          <div class="page-header">
            <div class="row">
              <div class="col-md-3.5 stretch-card grid-margin" >
                <div class="card bg-gradient-<?php echo $color ?> card-img-holder text-white" >
                  <div class="card-body" >
                    <h4 class="mb-5">Les soumission sur le matiere  <?php echo "". $row1['libelle'].""." " ?></h4>
                    <h6 class="card-text"></h6>
                  </div>
                </div>
              </div>
           
    <?php

    $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and ( status=0  or status=1) and date_debut <= Now()";
    $req = mysqli_query($conn , $req_detail);
    if (mysqli_num_rows($req) > 0) {

    while($row=mysqli_fetch_assoc($req)){
        ?>
        <tr >
        
       
           
              <div class="col-md-14 stretch-card grid-margin" >
                <div class="card bg-gradient card-img-holder text-black" id="tou" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)">
                  <div class="card-body div-hover" class="div-hover" style="display: flex;justify-content: left;padding: 15px; ">
                    <div class="btn-gradient-<?php echo $color ?>"  style="width: 37px;border-radius: 100%;height: 40px;display: flex;justify-content: center;align-items: center;margin-right: 10px;">
                      <i class="mdi mdi-book-open-page-variant " style="font-size: 20px;"></i> 
                    </div>
                    <div >
                      
                      <p class="m-0"> il ya  une nouveau soumission <?= $row['titre_sous'] ?> </p> 
                      <p style="margin: 0%;"><?= $row['date_debut'] ?> jousqua  <?= $row['date_fin']  ?> </p> 
                    </div>
                </div>
              </div>
              </div>
  
<?php
   
    }
    
}
    ?>
    </div>
    </div>
    </div>
    </div>
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->

<script>
      function redirectToDetails(id_sous) {
            window.location.href = "soumission_etu.php?id_sous=" + id_sous;
        }
</script>