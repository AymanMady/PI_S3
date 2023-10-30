
<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="ens"){
    header("location:authentification.php");
}
?>
<?php
    include_once "../connexion.php";

    $id_matiere=$_GET['id_matiere'];
    $req = mysqli_query($conn,"SELECT * FROM matiere where matiere.id_matiere ='$id_matiere' ");
    $row_matiere=mysqli_fetch_assoc($req);
    include "nav_bar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailler matiere par enseignant </title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
</br></br></br>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                </li>
                <li>Liste des etudiants s'inscrient dans la matière &nbsp;<b> <a> <?php echo $row_matiere['libelle']  ?></a> </b></li>     
            </ol>
        </div>
    </div>

    <div style="overflow-x:auto;">

<table class="table table-striped table-bordered table-hover">
    <tr>
    <th>Matricule</th>
    <th>Nom et Prénom</th>
    <th>Semestre</th>
    <th>E-mail</th>
    </tr>
    <?php 
    $req = mysqli_query($conn , "SELECT * FROM etudiant,semestre,inscription where etudiant.id_semestre=semestre.id_semestre and etudiant.id_etud=inscription.id_etud and id_matiere=$id_matiere  ORDER by matricule asc;");


    if(mysqli_num_rows($req) == 0){
        echo "Il n'y a pas encore des etudiants ajouter !" ;
        
    }else {
        while($row=mysqli_fetch_assoc($req)){
            ?>
            <tr>
                <td><?=$row['matricule']?></td>
                <td><?=$row['nom']?>
                <?=$row['prenom']?></td>
                <?php $row['lieu_naiss']?>
                <?php $row['Date_naiss']?>
                <td><?=$row['nom_semestre']?></td>
                <?php $row['annee']?>
                <td><?=$row['email']?></td>
           </tr>
            <?php
        }
    }
?>

</table>
</div>

</body>
</html>
