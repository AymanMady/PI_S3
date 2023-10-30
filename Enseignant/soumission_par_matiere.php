
<?php

// echo $color_hover;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
           tr:hover {
            cursor: pointer;
            background-color: aliceblue;
        }
        .div-hover:hover {
          background-color: #dfe9f7;
          background-color: <?php echo $color_hover; ?>;
           /* background-color: #24b2d016; */
          cursor: pointer; /* Changer le curseur de la souris */
        }
        .div-hover{
          border: 1px solid rgb(209, 206, 206);
          border-radius: 5px;
        }


        
    </style>

</head>
<body>
    


<?php session_start() ;

// $id_matiere=$_GET['id_matiere'];
if (isset($_GET["id_matiere"])){
  $id_matiere=$_GET["id_matiere"];

}
else{
  $id_matiere=$_SESSION['id_matirer'];
}
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:authentification.php");
 }
 $color = $_GET["color"];
 $color_hover = $_GET["color_hover"];

 include_once "../connexion.php";
 include "nav_bar.php";
 if(isset($_POST['filtrer'])){
            
  if(!empty($_POST['soul'])){
        $type=$_POST['soul'];

        $req_sous1 =  "SELECT DISTINCT soumission.*,matiere.* 
        FROM soumission ,matiere,enseignant,enseigner 
        WHERE enseigner.id_matiere=soumission.id_matiere and
         soumission.id_ens=enseignant.id_ens AND
          soumission.id_matiere=matiere.id_matiere and 
          enseignant.email='$email' AND
           soumission.id_type_sous = $type and
           matiere.id_matiere=$id_matiere  and
            status = 0 and matiere.id_matiere 
            IN (SELECT enseigner.id_matiere 
            FROM enseigner,enseignant 
            WHERE enseigner.id_ens=enseignant.id_ens and
             enseignant.email='$email')   ORDER BY date_debut DESC ";
        $req1 = mysqli_query($conn , $req_sous1);
        $req_sous2 =  "SELECT DISTINCT soumission.*,matiere.* FROM
         soumission ,matiere,enseignant,enseigner 
         WHERE enseigner.id_matiere=soumission.id_matiere and
          soumission.id_ens=enseignant.id_ens AND
           soumission.id_matiere=matiere.id_matiere and
            enseignant.email!='$email' and status = 0 AND
             soumission.id_type_sous = $type and
             matiere.id_matiere=$id_matiere  and
              matiere.id_matiere 
              IN (SELECT enseigner.id_matiere FROM enseigner,enseignant 
              WHERE enseigner.id_ens=enseignant.id_ens and 
              enseignant.email='$email') ORDER BY date_debut DESC ";

        $req2 = mysqli_query($conn , $req_sous2);
    }
    elseif(!empty($_POST['soul'])){
     
        $type=$_POST['soul'];
     
        $req_sous1 =  "SELECT DISTINCT soumission.*,matiere.* FROM
         soumission ,matiere,enseignant,enseigner WHERE 
         enseigner.id_matiere=soumission.id_matiere and 
         soumission.id_ens=enseignant.id_ens AND 
         soumission.id_matiere=matiere.id_matiere and 
         enseignant.email='$email' and matiere.id_matiere=$id_matiere  and 
         soumission.id_type_sous = $type and  status = 0 and
          matiere.id_matiere IN (SELECT enseigner.id_matiere FROM 
          enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and
           enseignant.email='$email')  ORDER BY date_fin DESC ";



        $req1 = mysqli_query($conn , $req_sous1);
        $req_sous2 =  "SELECT DISTINCT soumission.*,matiere.* FROM 
        soumission ,matiere,enseignant,enseigner WHERE 
        enseigner.id_matiere=soumission.id_matiere and 
        soumission.id_ens=enseignant.id_ens AND
         soumission.id_matiere=matiere.id_matiere and
          enseignant.email!='$email' and status = 0
           and soumission.id_type_sous = $type and
            matiere.id_matiere IN (SELECT enseigner.id_matiere FROM
             enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and
              enseignant.email='$email')   ORDER BY date_fin DESC ";
        $req2 = mysqli_query($conn , $req_sous2);

      }
    }
      else{

$req_sous1 = "SELECT DISTINCT soumission.*, type_soumission.libelle AS 'libelle_type', matiere.libelle AS 'libelle_matiere', nom, prenom FROM
soumission ,matiere,enseignant,enseigner,type_soumission
 WHERE matiere.id_matiere=$id_matiere   and 
 soumission.id_type_sous=type_soumission.id_type_sous 
 and enseigner.id_matiere=soumission.id_matiere and
  soumission.id_ens=enseignant.id_ens AND 
  soumission.id_matiere=matiere.id_matiere and
   enseignant.email='$email' and status = 0 and
    matiere.id_matiere IN (SELECT enseigner.id_matiere FROM 
    enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and
     enseignant.email='$email')
 ORDER BY date_debut DESC";

// $req_sous1 = "SELECT * FROM soumission";


$req1 = mysqli_query($conn , $req_sous1);
$row = mysqli_fetch_array($req1);


$req_sous2 = "SELECT DISTINCT soumission.*,matiere.*,type_soumission.* FROM
 soumission ,matiere,enseignant,enseigner,type_soumission WHERE 
 matiere.id_matiere=$id_matiere and
  soumission.id_type_sous=type_soumission.id_type_sous and 
  enseigner.id_matiere=soumission.id_matiere and 
  soumission.id_ens=enseignant.id_ens AND
   soumission.id_matiere=matiere.id_matiere and 
   enseignant.email!='$email' and status = 0 and
    matiere.id_matiere IN (SELECT enseigner.id_matiere FROM
     enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and 
     enseignant.email='$email')
ORDER BY date_debut DESC";
  

$req2 = mysqli_query($conn , $req_sous2);
}

$ens = "SELECT DISTINCT matiere.* FROM matiere 
INNER JOIN soumission ON soumission.id_matiere = matiere.id_matiere  ";
$matiere_filtre_qry = mysqli_query($conn, $ens);
$row_mat = mysqli_fetch_array($matiere_filtre_qry);

            
$type_sous = "SELECT * FROM type_soumission";
$type_sous_qry = mysqli_query($conn, $type_sous);



      

if(mysqli_num_rows($req1) == 0 and mysqli_num_rows($req2) == 0){
 
    ?>


     <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                
                    
                </li>
                <li>Les soumissions en ligne dans la matière <?php echo $row_mat['libelle'] ?></li>
                   
            </ol>

        </div>
    </div>
      
          <div class="col-md-12 stretch-card grid-margin">
                <div class="card bg-gradient-<?php echo $color ?> card-img-holder text-white">
                  <div class="card-body ">
                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="mb-5" class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?=$row_mat['libelle']?></h4>
                    <h6 ></h6>
                    <div class="md-2">
                    </div>
                    
                  </div>
                </div>
              </div>
    <?php 
       echo "Il n'y a pas encore des soumissions dans cette matière !" ;

    
}
else if(mysqli_num_rows($req1)>0 or mysqli_num_rows($req2)>0) {
      ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                    
                </li>
                <li><h4>Les soumissions en ligne dans la matière <?php echo $row_mat['libelle']; ?></h4></li>
                   
            </ol>
        </div>
    </div>


    <?php 
         


            ?>

 

    </div>       


      <div class="container">
        <div class="col-md-12 stretch-card grid-margin">
                <div class="card bg-gradient-<?php echo $color ?> card-img-holder text-white">
                  <div class="card-body ">
                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="mb-5" class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?=$row['libelle_matiere']." ".$row['titre_sous']?></h4>
                    <h6 class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?=$row['nom']." ".$row['prenom']?></h6>
                    <div class="md-2">
                    </div>
                    
                  </div>
                </div>
              </div>
              <?php
            while($row=mysqli_fetch_assoc($req1)){
              ?>


            <div class="col-md-12 stretch-card grid-margin">
                <div class="card bg-gradient card-img-holder text-black">
                  <div class="card-body div-hover" class="div-hover" style="display: flex;justify-content: space-between;padding: 15px;">
                    <div style="display: flex;justify-content: space-between;padding: 15px;" >
                    <div class="btn-gradient-<?php echo $color ?>"  style="width: 40px;border-radius: 100%;height: 40px;display: flex;justify-content: center;align-items: center;margin-right: 10px;">
                      <i class="mdi mdi-book-open-page-variant " style="font-size: 20px;"></i> 

                    </div>
                    <div col-md-12>
 
                        <div class="btn-group ">
                        <h5 class="" class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?=$row['nom']." ".$row['prenom']?> a publié un nouveau support de cours &nbsp;: <?=$row['titre_sous']?>
                        
                        </h5>
                        </div>

                        <p style="margin: 0%; " <?php if (strtotime($row['date_fin']) - time() <= 600) echo 'style="color: red;"'; ?>> De&nbsp;<?=$row['date_debut']?>&nbsp;à&nbsp;
                        <?php
                          echo '<input type="datetime-local" id="date-fin-'.$row['id_sous'].'" value="'.date('Y-m-d H:i:s', strtotime($row['date_fin'])).'" onchange="modifierDateFin('.$row['id_sous'].', this.value)" style="border: none;" >';
                        ?>
                        </p> 
                      </div>
                    </div>
                    
                    <div>
                        <div class="col-sm-6 col-md-4 col-lg-3 float-end" data-bs-toggle="dropdown">
                            <i class="mdi mdi-dots-vertical"  style="font-size: 35px; margin-right:30px;"></i>
                        </div>
                        <h5 class="dropdown-menu">
                          <a class="dropdown-item" href="detail_soumission.php?id_sous=<?=$row['id_sous']?>">Detaille</a>
                          <a class="dropdown-item" href="cloturer.php?id_sous=<?=$row['id_sous']?>" id="cloturer">Clôturer</a>
                          <a class="dropdown-item" href="archiver_soumission_en_ligne.php?id_sous=<?=$row['id_sous']?>" id="archiver">Archiver</a>
                        </h5>
                    </div>
                </div>
              </div>
            </div>

 
      <?php
            }
        
        }
        ?>
    <div>
  <div>




</div>

    <script src="../JS/sweetalert2.js"></script>
    <script>
        function redirectToDetails(id_matiere) {
            window.location.href = "reponses_etud.php?id_sous=" + id_matiere;
        }
       
    </script>
    <script>

    



var liensArchiver = document.querySelectorAll("#archiver");

// Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
liensArchiver.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment archiver cette soumission ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "Archiver"
    }).then((result) => {
      if (result.isConfirmed) {
        // Swal.fire({
        //   title: "Archive réussie !",
        //   text: "La soumission a été archiver avec succès.",
        //   icon: "success",
        //   confirmButtonColor: "#3099d6",
        //   confirmButtonText: "OK",
        //   showConfirmButton: true
        // }).then((result) => {
        //   if (result.isConfirmed) {
            window.location.href = this.href; 
          }
        });
      });
    });
//   });
// });

// Sélectionner tous les éléments avec l'ID "cloturer"
var liensCloturer = document.querySelectorAll("#cloturer");

// Parcourir chaque lien de clôture et ajouter un écouteur d'événements
liensCloturer.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment clôturer cette soumission ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "Clôturer"
    }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = this.href; 
          }
        });
      });
    });
  



// Fonction pour modifier la date de fin
function modifierDateFin(id_sous, nouvelle_date_fin) {
  // Créer un objet FormData pour envoyer les données via AJAX
  var formData = new FormData();
  formData.append('id_sous', id_sous);
  formData.append('nouvelle_date_fin', nouvelle_date_fin);

  // Envoyer la requête AJAX
  fetch('modifier_date_fin.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    // Vérifier le statut de la réponse JSON
    if (data.status === 'success') {
      // Afficher une boîte de dialogue de succès
      Swal.fire({
        title: 'Succès',
        text: data.message,
        icon: 'success',
        confirmButtonColor: '#3099d6'
      });
    } else {
      // Afficher une boîte de dialogue d'erreur
      Swal.fire({
        title: 'Erreur',
        text: data.message,
        icon: 'error',
        confirmButtonColor: '#3099d6'
      });
    }
  })
  .catch(error => {
    console.error('Une erreur s\'est produite lors de la requête AJAX :', error);
  });
}

</script>
    </body>
</html>
