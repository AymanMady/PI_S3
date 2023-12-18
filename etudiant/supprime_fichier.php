
<?php 
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="etudiant"){
     header("location:../authentification.php");
 }

include_once "../connexion.php";
$id_sous = $_GET['id_sous'];
$_SESSION['id_sous'] = $id_sous;
$id_matiere = $_GET['id_matiere'];
$color = $_GET['color'];
$nom_semestre = $_GET['nom_semestre'];
$nom_matiere = $_GET['nom_matiere'];
$file=$_GET['file_name'];
$sql="DELETE FROM fichiers_reponses WHERE fichiers_reponses.nom_fichiere='$file'";
$resul=mysqli_query($conn,$sql);
if($resul){

    $_SESSION['suppression_reussi'] = true ;
    header("location:reponse_etudiant.php?id_matiere=$id_matiere&color=$color&nom_semestre=$nom_semestre&nom_matiere=$nom_matiere");
}
?>
