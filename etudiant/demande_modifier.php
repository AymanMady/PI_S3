<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
?>
<?php
        include_once "../connexion.php";

        $email = $_SESSION['email'];
        $req = mysqli_query($conn, "SELECT * FROM etudiant WHERE email = '$email'");
        $row = mysqli_fetch_assoc($req);
      
        $id_etud = $row['id_etud'];
        $id_sous = $_GET['id_sous'];

    function test_input($data){
            $data = htmlspecialchars($data);
            $data = trim($data);
            $data = htmlentities($data);
            $data = stripcslashes($data);
            return $data;
        }
    if(isset($_POST['button'])){
    $description = test_input($_POST['description']);

        if( !empty($description)  ){
            $req = mysqli_query($conn , "INSERT INTO `demande` (`id_sous`,`id_etud`,`description`) VALUES($id_sous, $id_etud,'$description')");
            if($req){
                // echo "<script>window.location.href='soumission_etu.php?id_sous=".$id_sous."</script>";
                header("location:soumission_etu.php?id_sous=$id_sous");
            }else {
                $message = "message n'est pas envoyé";
            }

        }else {
            $message = "Veuillez remplir tous les champs !";
        }
    }
    include "nav_bar.php";

?>
<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Demande de modification : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample">
                      <div class="form-group">
                            <label>Description : </label>
                            <div class="col-md-12">
                                <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                      <button type="submit" name="button" class="btn btn-gradient-primary me-2">Envoyer</button>
                      <a href="groupe.php" class="btn btn-light">Annuler</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>