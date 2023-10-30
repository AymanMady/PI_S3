<?php 
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="etudiant"){
     header("location:../authentification.php");
 }

include_once "../connexion.php";


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
<div class="container">
    <div class="row">
    
    </div>
   
<div class="form-horizontal">
    <br /><br />
    <p class="erreur_message">
            <?php 
            if(isset($message)){
                echo $message;
            }
            ?>

        </p>
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-md-1">Description </label>
            <div class="col-md-6">
                <textarea name="description_sous" id="" class = "form-control" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="form-group">
                    <label class="col-md-1">Sélectionnez un fichier : </label>
                    <div class="col-md-6">
                        <input type="file" id="fichier" name="file[]" class="form-control" multiple>
                    </div>
                </div>
                <div id="newElementId"></div>
                <br><br><br>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" name="button" value="Enregistrer" class="btn-primary" />
                    </div>
                </div>
</form>

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
</br></br></br>

 <div class="content-wrapper">
    
 <div style="overflow-x:auto;">
    <div class="row" >
    <div class="col-md-6">
               
                    <fieldset class="fsStyle" style="width: 2000px;">
                       
                       
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="search-box">
                                        <div class="col-md-4 col-sm-2">
                                            <div class="form-group " style="width: 600px;">
                                                <label class="col-md-4">Description : </label>
                                                <br><br>
                                                <div class="col-md-5" style="width: 350px;">
                                                    <textarea name="description_sous" id="" class = "form-control" cols="30" rows="10" ><?=$row['description_rep']?></textarea>
                                                </div>
                                         
                                            </div>
                                        </div>
                                     </div>
                                     <div class="search-box">
                                        <div class="col-md-5 col-sm-2">
                                            <div class="form-group " style="width: 700px;">
                                            <label class="col-md-4" style="margin-top: 30px;">Sélectionnez un fichier : </label>
                                                <br><br>
                                                <div class="col-md-5" style="width: 350px;">
                                                        <input type="file" id="fichier" name="file[]" class="form-control" multiple>
                                                  
                                                </div>
                                         
                                            </div>
                                            <div class="form-group" style="margin-left:100px; ">
                                                    <div class="col-md-6" style="margin-top: 50px;">
                                                        <input type="submit" name="button" value="Enregistrer" class="btn-primary" />
                                                        
                                                    </div>
                                                    </div>
                                        </div>
                                     </div>
                 </div>
                 <div class="col-md-9 stretch-card grid-margin" style="height: 500px;width:600px">
                <div class="card bg-gradient-success card-img-holder text-white">
                     <br><strong style="top: 2;left: 0;color:aqua"  >Le(s) liste(s) de Fichier(s)</strong><br>
                <div >
                <?php
                    
                                $sql2 = "select * from fichiers_reponses,reponses,etudiant where fichiers_reponses.id_rep=reponses.id_rep and reponses.id_etud=etudiant.id_etud AND email='$email' And reponses.id_sous= '$id_sous';";
                                $req2 = mysqli_query($conn,$sql2);
                                if(mysqli_num_rows($req2) == 0){
                                    ?>
                        <div>
                        <?php
                                    echo "Il n'y a pas des fichier ajouter !" ;
                                    ?>
                                       
                        </div>
                        </div>
                        <?php
                                }else {
                                    while($row2=mysqli_fetch_assoc($req2)){
                                        ?>
                                        <?php 
                                        $file_name = $row2['nom_fichiere']; 
                                        $id_rep = $row2['id_rep'];
                                        ?>
                                        <div style="display: flex ; justify-content: center;align-items: center;">
                                        <div>
                                        <p><?=$row2['nom_fichiere']?></p>
                                        </div>
                                        <div>
                                        <?php 
                                        $test=explode(".",$file_name);
                                        if( $test[1]=="pdf"){
                                        ?>
                                        <a href="open_file.php?file_name=<?=$file_name?>&id_rep=<?=$id_rep?>">Voir</a>
                                        </div>
                                        <?php 
                                        }
                                        else{
                                            ?>
                                            <a >Voir</a>
                                            </div>
                                            <?php 
                                            }
                                        
                                        ?>
                                        <div>
                                        <a href="telecharger_fichier.php?file_name=<?=$file_name?>&id_rep=<?=$id_rep?>">Telecharger</a>
                                        </div>
                                        <div>
                                        <a href="supprime_fichier.php?file_name=<?=$file_name?>&id_sous=<?=$id_sous?>"><img style="width: 18px; margin-left:110px; " title="Supprimer" src="images/close.png" alt=""></a>
                                        </div>
                                        


                                        <br>
                                        <br> <br>
                                        <?php
                                    }
                                }
                            ?> 
                </div>
                            
                <br>
    
    
    

    
    </div>
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
