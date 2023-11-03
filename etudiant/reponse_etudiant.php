
<?php 
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="etudiant"){
     header("location:../authentification.php");
 }

include_once "../connexion.php";
?>

<?php

if(!empty($_GET['id_sous'])){
    $id_sous = $_GET['id_sous'];
}else{
    $id_sous= $_SESSION['id_sous'];
}

?>
 


<?php
$sql = "select * from reponses where id_sous = ' $id_sous' and id_etud = (select id_etud from etudiant where email = '$email') ";
$req = mysqli_query($conn,$sql);

if (mysqli_num_rows($req) == 0) { 

function test_input($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = htmlentities($data);
    $data = stripslashes($data);
    return $data;
}

if (isset($_POST['button'])) {
    $descri=test_input($_POST['description_sous']);
    $files = $_FILES['file'];
    if( !empty($descri) or !empty($files) ){
    $sql="INSERT INTO `reponses`(`description_rep`, `id_sous`, `id_etud`) VALUES('$descri','$id_sous',(select id_etud from etudiant where email = '$email')) ";

    $req1 = mysqli_query($conn,$sql);
    
    $id_rep = mysqli_insert_id($conn);
    foreach ($files['tmp_name'] as $key => $tmp_name) {
        $file_name = $files['name'][$key];
        $file_tmp = $files['tmp_name'][$key];
        $file_size = $files['size'][$key];
        $file_error = $files['error'][$key];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_error === 0) {
            $new_file_name = uniqid('', true) . '.' . $file_ext;

			$sql3 = "SELECT matricule FROM etudiant WHERE etudiant.email = '$email'";
			$code_matiere_result = mysqli_query($conn, $sql3);
			$row = mysqli_fetch_assoc($code_matiere_result);
			$matricule = $row['matricule'];
            $matricule_directory = 'C:/wamp64/www/projet_sous-main/Files/' . $matricule;

            // Créer le dossier s'il n'exist pas
            if (!is_dir($matricule_directory)) {
                mkdir($matricule_directory, 0777, true);
            }

            // Chemin complet 
            $destination = $matricule_directory . '/' . $new_file_name;
            move_uploaded_file($file_tmp, $destination);

            // Insérer les info dans la base de donnéez
            $sql2 = "INSERT INTO `fichiers_reponses` (`id_rep`, `nom_fichiere`, `chemin_fichiere`) VALUES ($id_rep, '$file_name', '$destination')";
            $req2 = mysqli_query($conn, $sql2);
            if($req1 and $req2){
                $_SESSION['id_sous'] = $id_sous;
                $_SESSION['ajout_reussi'] = true;
                header("location:soumission_etu.php");
            }
        }
    }
}
}
include "nav_bar.php";

?>


<div class="form-horizontal">
    <br />
    <p class="erreur_message">
            <?php 
            if(isset($message)){
                echo $message;
            }
            ?>

        </p>
</div>


<div class="col-md-5 grid-margin">
    <div class="card">
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputUsername1" class="col-md-4">Description : </label>
                    <textarea id="exampleInputUsername1" name="description_sous" id="" class = "form-control" cols="30" rows="10" ></textarea>
                </div>
                    <div class="form-group ">
                    <label for="exampleInputUsername1"  >Sélectionnez un fichier : </label>
                            <input type="file" id="fichier" name="file[]" class="form-control" multiple> 
                    </div>
            </form>
        </div>
    </div>
</div>


<?php
}else{
    function test_input($data){
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = stripcslashes($data);
        return $data;
    }

    if (isset($_POST['button'])) {
        $descri=test_input($_POST['description_sous']);
        $files = $_FILES['file'];
        if( !empty($descri) or !empty($files) ){
        $sql="UPDATE reponses set description_rep = '$descri' ,  `date` = NOW() where id_sous = $id_sous and id_etud=(select id_etud from etudiant where email = '$email') ";
    
        $req1 = mysqli_query($conn,$sql);
        
        $id_rep = mysqli_insert_id($conn);
        foreach ($files['tmp_name'] as $key => $tmp_name) {
            $file_name = $files['name'][$key];
            $file_tmp = $files['tmp_name'][$key];
            $file_size = $files['size'][$key];
            $file_error = $files['error'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
            if ($file_error === 0) {
                $new_file_name = uniqid('', true) . '.' . $file_ext;
    
                $sql3 = "SELECT matricule FROM etudiant WHERE etudiant.email = '$email'";
                $code_matiere_result = mysqli_query($conn, $sql3);
                $row = mysqli_fetch_assoc($code_matiere_result);
                $matricule = $row['matricule'];
                $matricule_directory = 'C:/wamp64/www/projet_sous-main/Files/' . $matricule;
    
                // Créer le dossier s'il n'exist pas
                if (!is_dir($matricule_directory)) {
                    mkdir($matricule_directory, 0777, true);
                }
    
                // Chemin complet 
                $destination = $matricule_directory . '/' . $new_file_name;
                move_uploaded_file($file_tmp, $destination);
    
                // Insérer les info dans la base de donnéez
                $sql2 = "INSERT INTO `fichiers_reponses` (`id_rep`, `nom_fichiere`, `chemin_fichiere`) VALUES ((SELECT reponses.id_rep FROM reponses,etudiant WHERE reponses.id_etud=etudiant.id_etud and email='$email' and reponses.id_sous=$id_sous), '$file_name', '$destination')";
                $req2 = mysqli_query($conn, $sql2);

                
                if($req1 && $req2){
                    $_SESSION['id_sous'] = $id_sous;
                    $_SESSION['ajout_reussi'] = true;
                    header("location:soumission_etu.php");
                }else{
                    mysqli_connect_error();
                }
                
            }
        }
    }
    }
    $sql = "SELECT * FROM reponses  WHERE  id_sous = '$id_sous' and id_etud = (select id_etud from etudiant where email = '$email')";
    $req1 = mysqli_query($conn , $sql);
    $row = mysqli_fetch_assoc($req1);
  
include "nav_bar.php";
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
        

                <div class="col-md-5 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputUsername1" class="col-md-4">Description : </label>
                                    <textarea id="exampleInputUsername1" name="description_sous"  class = "form-control" cols="30" rows="10" ><?=$row['description_rep']?></textarea>
                                </div>
                                    <div class="form-group ">
                                    <label for="exampleInputUsername1"  >Sélectionnez un fichier : </label>
                                            <input type="file" id="fichier" name="file[]" class="form-control" multiple> 
                                    </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-7 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Le(s) liste(s) de Fichier(s)</p>
                            <?php
                                
                                $sql2 = "select * from fichiers_reponses,reponses,etudiant where fichiers_reponses.id_rep=reponses.id_rep and reponses.id_etud=etudiant.id_etud AND email='$email' And reponses.id_sous= '$id_sous';";
                                $req2 = mysqli_query($conn,$sql2);
                                if(mysqli_num_rows($req2) == 0){
                            ?>
                                <?php
                                    echo "Il n'y a pas des fichier ajouter !" ;
                                 ?>
                                <ul style="list-style: none;">
                                <?php
                                }else {
                                    while($row2=mysqli_fetch_assoc($req2)){
                                        ?>
                                        <?php 
                                        $file_name = $row2['nom_fichiere']; 
                                        $id_rep = $row2['id_rep'];
                                        ?>
                                          <li style="list-style: none;">
                                          <?=$row2['nom_fichiere']?>
                                        <?php 
                                        $test=explode(".",$file_name);
                                        if( $test[1]=="pdf"){
                                        ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="open_file.php?file_name=<?=$file_name?>&id_rep=<?=$id_rep?>"> Voir</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php 
                                        }
                                        else{
                                            ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a >Voir</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php 
                                            }
                                        
                                        ?>
                                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="telecharger_fichier.php?file_name=<?=$file_name?>&id_rep=<?=$id_rep?>">Telecharger</a>
                                        <a href="supprime_fichier.php?file_name=<?=$file_name?>&id_sous=<?=$id_sous?>"><img style="width: 18px; margin-left:110px; " title="Supprimer" src="images/close.png" alt=""></a>
                                        </li>
                                        <br>

                                        <?php
                                    }
                                }
                            ?> 
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="form-group" >
                    <div class="col-md-6" >
                        <input type="submit" name="button" value="Enregistrer" class="btn btn-primary" />  
                    </div>
                </div>
            </div>
            </form>

         </div>
    </div>
</div>  




<?php
if (isset($_SESSION['suppression_reussi']) && $_SESSION['suppression_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'clôture réussi !',
        text: 'Le fichier a été supprimer avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";
  
    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['suppression_reussi']);
  }
 
}
?>


