<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location:authentification.php");
}

include_once "../connexion.php";

$semestre = "SELECT   matiere.*,enseigner.*,enseignant.* FROM matiere, enseigner, enseignant 
    WHERE matiere.id_matiere = enseigner.id_matiere AND
    enseigner.id_ens = enseignant.id_ens AND email='$email'";
$semestre_qry = mysqli_query($conn, $semestre);

$type_sous = "SELECT * FROM type_soumission";
$type_sous_qry = mysqli_query($conn, $type_sous);

$persone_contact = "SELECT * FROM enseignant";
$persone_contact_qry = mysqli_query($conn, $persone_contact);


function test_input($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = htmlentities($data);
    $data = stripslashes($data);
    return $data;
}

if (isset($_POST['button'])) {
    $id_matiere = test_input($_POST['matiere']);
    $date_debut = test_input($_POST['debut']);
    $date_fin = test_input($_POST['fin']);
    $type = test_input($_POST['type']);
    $personC = test_input($_POST['personC']);
    $files = $_FILES['file'];

    $titre = test_input($_POST['titre_sous']);
    $descri = test_input($_POST['description_sous']);


    // Vérifiez si la date de début est supérieure ou égale à la date de fin
    if (strtotime($date_debut) >= strtotime($date_fin)) {
        $message = "La date de début doit être antérieure à la date de fin. Veuillez corriger les dates.";
    } else {

        $sql1 = "INSERT INTO `soumission`(`titre_sous`, `description_sous`,`person_contact`, `id_ens`, `date_debut`, `date_fin`, `valide`, `status`, `id_matiere`,`id_type_sous`) VALUES 
        ('$titre', '$descri','$personC',(SELECT id_ens FROM enseignant
        WHERE email = '$email'), '$date_debut', '$date_fin', 0, 0, $id_matiere,'$type')";
        $req1 = mysqli_query($conn, $sql1);

        $id_sous = mysqli_insert_id($conn);
        foreach ($files['tmp_name'] as $key => $tmp_name) {
            $file_name = $files['name'][$key];
            $file_tmp = $files['tmp_name'][$key];
            $file_size = $files['size'][$key];
            $file_error = $files['error'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($file_error === 0) {
                $new_file_name = uniqid('', true) . '.' . $file_ext;

                $sql3 = "SELECT code FROM matiere WHERE matiere.id_matiere = '$id_matiere'";
                $code_matiere_result = mysqli_query($conn, $sql3);
                $row = mysqli_fetch_assoc($code_matiere_result);
                $code_matire = $row['code'];
                $matiere_directory = 'C:/wamp64/www/projet_sous-main/Files/' . $code_matire;

                // Créer le dossier s'il n'exist pas
                if (!is_dir($matiere_directory)) {
                    mkdir($matiere_directory, 0777, true);
                }

                // Chemin complet 
                $destination = $matiere_directory . '/' . $new_file_name;
                move_uploaded_file($file_tmp, $destination);

                // Insérer les info dans la base de donnéez
                $sql2 = "INSERT INTO `fichiers_soumission` (`id_sous`, `nom_fichier`, `chemin_fichier`) VALUES ($id_sous, '$file_name', '$destination')";
                $req2 = mysqli_query($conn, $sql2);
                if($req1 and $req2){
                    $sql_tou="SELECT * FROM `inscription` WHERE inscription.id_matiere='$id_matiere'";
                    $req_tou=mysqli_query($conn,$sql_tou);
                    // while($row_tou=mysqli_fetch_assoc($req_tou)){
                    //     $id_etud=$row_tou['id_etud'];
                    //     $sql_tout="SELECT * FROM `etudiant` where id_etud=$id_etud";
                    //     $req_tout=mysqli_query($conn,$sql_tout);
                    //     $row_tout=mysqli_fetch_assoc( $req_tout);
                    //     $subject = "il ya une soumission  ";
                    //     $message = "date de debus de test est $date_debut   
                    //     alors que date de fin est $date_debut ";
                    //     //  $url =  "https://script.google.com/macros/s/AKfycbz1KWjBC8wx3Ay9fYYg6pW_1dcS-07rYT07Xxq0SscKOgUXpiPcq5zqgfTsR7PZFr4j/exec";
                    //         // $ch = curl_init($url);
                    // curl_setopt_array($ch, [
                    //    CURLOPT_RETURNTRANSFER => true,
                    //    CURLOPT_FOLLOWLOCATION => true,
                    //    CURLOPT_POSTFIELDS => http_build_query([
                    //       "recipient" =>$row_tout['matricule'],
                    //       "subject"   =>$subject,
                    //       "body"      =>$message
                    //    ])
                    // ]); 
                    //    $result = curl_exec($ch);
                    

                    // }
                    // if ($result) {
                    header("location:soumission_en_ligne.php");
                    $_SESSION['ajout_reussi'] = true;
                    // }
                }
            }
        }
    }

}

include "nav_bar.php";
?>

<script type="text/JavaScript">
    var i = 1;

    function ToAction(url) {
        window.location.href = url;
    }
</script>

<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Créer une soumission : </h4>
                    
                    <p class="erreur_message">
                        <?php
                        if (isset($message)) {
                            ?>
                            <div class="alert alert-danger" id="success-alert" >
                                <!-- <span aria-hidden="true">&times;</span> -->
                                <?php echo $message; ?>
                            </div>

                        <?php
                        }
                        ?>
                    </p>

            <form action="" method="POST" enctype="multipart/form-data" class="forms-sample">
                <div class="form-group">
                    <label >Titre </label>
                    <div class="col-md-12">
                        <input type="text" name="titre_sous" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label >Matière</label>
                    <div class="col-md-12">
                        <select class="form-control" id="academic" value="Semesters" name="matiere">
                            <option selected disabled> Matière </option>
                            <?php while ($row = mysqli_fetch_assoc($semestre_qry)) : ?>
                                <option value="<?= $row['id_matiere']; ?>"><?= $row['code']; ?> <?= $row['libelle']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label >Date début </label>
                    <div class="col-md-12">
                        <input type="datetime-local" name="debut" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label >Date fin</label>
                    <div class="col-md-12">
                        <input type="datetime-local" name="fin" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label >Type soumission</label>
                    <div class="col-md-12">
                        <select class="form-control" id="academic" value="Semesters" name="type">
                            <option selected disabled> Type soumission </option>
                            <?php while ($row_type_sous = mysqli_fetch_assoc($type_sous_qry)) : ?>
                                <option value="<?= $row_type_sous['id_type_sous']; ?>"> <?= $row_type_sous['libelle']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label >Personne à contacter</label>
                    <div class="col-md-12">
                        <select class="form-control" id="academic" value="<?php echo $email;?>" name="personC">
                            <option selected > <?php echo $email;?> </option>
                            <?php while ($row_persone_contact = mysqli_fetch_assoc($persone_contact_qry)) : ?>
                                <option value="<?= $row_persone_contact['id_ens']; ?>"> <?= $row_persone_contact['email']; ?> </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label >Description </label>
                    <div class="col-md-12">
                        <textarea name="description_sous" id="" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label >Sélectionnez un ou plusieurs fichier(s) : </label>
                    <div class="col-md-12">
                        <input type="file" id="fichier" name="file[]" class="form-control" multiple>
                    </div>
                </div>
                <div id="newElementId"></div>
                <br><br><br>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input type="submit" name="button" value="Enregistrer" class="btn btn-gradient-primary me-2" />
                    </div>
                </div>
            </form>
            </div>
                </div>
              </div>
        </div>
    </div>

