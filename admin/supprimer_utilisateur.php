<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"] != "admin"){
    header("location:authentification.php");
}
include_once "../connexion.php";
$id_user= $_GET['id_user'];

$sql_role = "SELECT * FROM utilisateur WHERE id_user = $id_user";
$req_role = mysqli_query($conn, $sql_role);
$row_role = mysqli_fetch_assoc($req_role);

// Vérifier que l'utilisateur n'est pas un administrateur (rôle 1)
if ($row_role['id_role'] != 1) {
    $req1 = mysqli_query($conn , "DELETE FROM utilisateur WHERE id_user = $id_user");
    if($req1){
        header("location:utilisateurs.php");
        $_SESSION['supp_reussi'] = true;
    }else{
      $_SESSION['supp_reussi'] = false;
    }
}else{
  header("location:utilisateurs.php");
  $_SESSION['supp_non_reussi'] = true;   
}
?>