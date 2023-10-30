
<br>
<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:../authentification.php");
 }
?>

    <style>
        /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
        tr:hover {
            cursor: pointer;
            background-color: aliceblue;
        }
    </style>
<body>
 
<?php 
include "nav_bar.php";
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                <li><a href="index_enseignant.php">Acceuil</a>
                    
                </li>
                <li>Les soumissions limiter</li>
                   
            </ol>
        </div>
    </div>
    <?php 
           $ens = "SELECT DISTINCT matiere.* FROM matiere 
           INNER JOIN soumission ON soumission.id_matiere = matiere.id_matiere ";
           $matiere_filtre_qry = mysqli_query($conn, $ens);

                       
           $type_sous = "SELECT * FROM type_soumission";
           $type_sous_qry = mysqli_query($conn, $type_sous);

            ?>


<div class="row">
        <div class="col-lg-12">
            <div class="well">
                <form action="" method="post">
                    <fieldset class="fsStyle">
                        <div class="collapse in" id="demo">
                            <div class="search-box">

                                <div class="form-group">
                                        <label class="col-md-3" style="color:aliceblue;">. </label>
                                        <div class="col-md-3">
                                        <select  name="code" id="modi" class = "form-control">
                                            <option selected disabled> Code matière </option>
                                                    <?php  while ($row_ens = mysqli_fetch_assoc($matiere_filtre_qry)) :?>
                                                    <option value="<?= $row_ens['code']; ?>"> <?= $row_ens['code'] ?> </option>  
                                                <?php endwhile;?>
                                              </select>

                                        </div>
                                        <div class="col-md-3">
                                        <select  name="soul" id="modi1" class = "form-control">
                                                <option selected disabled> Type soumission </option>
                                                <?php while ($row_type_sous = mysqli_fetch_assoc($type_sous_qry)) : ?>
                                                    <option value="<?= $row_type_sous['id_type_sous']; ?>"> <?= $row_type_sous['libelle']; ?> </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                          
                                </div>
                                <input type="submit" value="filtre" name="filtrer" class="btn btn-info">

                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div> 

<div style="overflow-x:auto;">
  <table class="table table-striped table-bordered">
          <tr>
              <th>Code</th>
              <th>Titre de soumission</th>
              <th>Date debut </th>
              <th>Date fin </th>
              <th colspan="4">Actions</th>
          </tr>
          <?php 
              include_once "../connexion.php";
            //   $req_sous =  "SELECT * FROM soumission inner join matiere using(id_matiere)  WHERE status = 1 or date_fin <= NOW() ";
            if(isset($_POST['filtrer'])){
                if(!empty($_POST['code']) && empty($_POST['soul'])){
                $code=$_POST['code'];
                $req_sous =  "SELECT DISTINCT soumission.*,matiere.* FROM soumission ,matiere,enseignant WHERE  soumission.id_ens=enseignant.id_ens AND soumission.id_matiere=matiere.id_matiere and  status = 1 and `matiere`.`code`='$code' and matiere.id_matiere IN (SELECT enseigner.id_matiere FROM enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and enseignant.email='$email')  ORDER BY date_fin DESC   ";
                $req = mysqli_query($conn , $req_sous);
                }
                elseif(empty($_POST['code']) && !empty($_POST['soul'])){
                    $type=$_POST['soul'];
                    
                    $req_sous =  "SELECT DISTINCT soumission.*,matiere.* FROM soumission ,matiere,enseignant WHERE  soumission.id_ens=enseignant.id_ens AND soumission.id_matiere=matiere.id_matiere and  status = 1 and soumission.id_type_sous = $type and matiere.id_matiere IN (SELECT enseigner.id_matiere FROM enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and enseignant.email='$email')  ORDER BY date_fin DESC  ";
                    $req = mysqli_query($conn , $req_sous);
               
               
            }
                elseif(!empty($_POST['code']) && !empty($_POST['soul'])){
                    $code=$_POST['code'];
                    $type=$_POST['soul'];
                 
                        $type=$_POST['soul'];
                            $req_sous =  "SELECT DISTINCT soumission.*,matiere.* FROM soumission ,matiere,enseignant WHERE  soumission.id_ens=enseignant.id_ens AND soumission.id_matiere=matiere.id_matiere and  status = 1 and `matiere`.`code`='$code' and soumission.id_type_sous = $type and matiere.id_matiere IN (SELECT enseigner.id_matiere FROM enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and enseignant.email='$email')  ORDER BY date_fin DESC ";
                            $req = mysqli_query($conn , $req_sous);
                 
                }
                else{
                  echo '<div class="alert alert-info" row-md-15" id="success-alert">
                  <span aria-hidden="true">&times;</span>
                  <strong>Aucun séléction !</strong>
                  </div>';
                  exit;
                }
              }
              else{ 
                
                  $req_sous =  "SELECT DISTINCT soumission.*,matiere.* FROM soumission ,matiere,enseignant WHERE  soumission.id_ens=enseignant.id_ens AND soumission.id_matiere=matiere.id_matiere and  status = 1  and matiere.id_matiere IN (SELECT enseigner.id_matiere FROM enseigner,enseignant WHERE enseigner.id_ens=enseignant.id_ens and enseignant.email='$email')  ORDER BY date_fin DESC  ";
                  $req = mysqli_query($conn , $req_sous);
                                    }
            $req = mysqli_query($conn , $req_sous);
              if(mysqli_num_rows($req) == 0){
                  echo "Il n'y a pas encore des soumission ajouter !" ;
              }else {
                  while($row=mysqli_fetch_assoc($req)){
                    ?>

                      <tr>
                          <td class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)" ><?=$row['code']?></td>
                          <td class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?=$row['titre_sous']?></td>
                          <td class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)" ><?=$row['date_debut']?></td>
                          <td <?php if (strtotime($row['date_fin']) - time() <= 600) echo 'style="color: red;"'; ?>>
                            <input type="datetime-local" id="date-fin-<?=$row['id_sous']?>" value="<?=$row['date_fin']?>" onchange="modifierDateFin(<?=$row['id_sous']?>, this.value)" style="border: none;" >
                          </td>                          
                          <td><a href="detail_soumission.php?id_sous=<?=$row['id_sous']?>">Detaille</a></td>
                          <td><a href="archiver_soumission_terminer.php?id_sous=<?=$row['id_sous']?>" id="archiver" >Archiver</a></td>
                          <td><a href="prolonger_soumission.php?id_sous=<?=$row['id_sous']?>" id="prolonger" >Prolonger</a></td>
                      </tr>
                    <?php
                  }
            }
            
          ?>
        </table>
        </div>
</div>
</body>
</html>
<script src="../JS/sweetalert2.js"></script>

<?php


if (isset($_SESSION['archive_reussi']) && $_SESSION['archive_reussi'] === true) {
  echo "<script>
  Swal.fire({
      title: 'Archive réussi !',
      text: 'La soumission a été archiver avec succès.',
      icon: 'success',
      confirmButtonColor: '#3099d6',
      confirmButtonText: 'OK'
  });
  </script>";

  // Supprimer l'indicateur de succès de la session
  unset($_SESSION['archive_reussi']);
}

if (isset($_SESSION['prolongement_reussi']) && $_SESSION['prolongement_reussi'] === true) {
  echo "<script>
  Swal.fire({
      title: 'prolongement réussi !',
      text: 'La soumission a été prolonger avec succès.',
      icon: 'success',
      confirmButtonColor: '#3099d6',
      confirmButtonText: 'OK'
  });
  </script>";

  // Supprimer l'indicateur de succès de la session
  unset($_SESSION['prolongement_reussi']);
}

?>

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




        function redirectToDetails(id_matiere) {
            window.location.href = "reponses_etud.php?id_sous=" + id_matiere;
        }

var liensArchiver = document.querySelectorAll("#prolonger");

// Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
liensArchiver.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment prolonger cette soumission ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "prolonger"
    }).then((result) => {
      
          if (result.isConfirmed) {
            window.location.href = this.href; 
          }
        });
      });
    });




</script>
