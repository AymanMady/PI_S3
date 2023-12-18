<script src="../JS/sweetalert2.js"></script>

<?php
session_start();
$id_matiere = $_GET['id_matiere'];
$color = $_GET['color'];
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
}

include_once "../connexion.php";
?>

<?php

if (!empty($_GET['id_sous'])) {
    $id_sous = $_GET['id_sous'];
} else {
    $id_sous = $_SESSION['id_sous'];
}


if (!isset($_SESSION['autorisation']) && $_SESSION['autorisation'] != true) {
    $_SESSION['id_sous'] = $id_sous;
    header("location:soumission_etu.php");
}
?>



<?php
$sql = "select * from reponses where id_sous = ' $id_sous' and id_etud = (select id_etud from etudiant where email = '$email') ";
$req = mysqli_query($conn, $sql);

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

        $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
        $req3 = mysqli_query($conn, $req_detail3);
        if (mysqli_num_rows($req3) > 0) {
            $descri = test_input($_POST['description_sous']);
            $files = $_FILES['file'];
            if (!empty($descri) or !empty($files)) {
                $sql = "INSERT INTO `reponses`(`description_rep`, `id_sous`, `id_etud`) VALUES('$descri','$id_sous',(select id_etud from etudiant where email = '$email')) ";

                $req1 = mysqli_query($conn, $sql);

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
                        if ($req1 and $req2) {
                            $id_matiere = $_GET['id_matiere'];
                            $color = $_GET['color'];
                            $_SESSION['id_sous'] = $id_sous;
                            $_SESSION['ajout_reussi'] = true;
                            header("location:reponse_etudiant.php?id_matiere=$id_matiere&color=$color");
                            echo '';
                        }
                    }
                }
            }
        } else {
            $_SESSION['id_sous'] = $id_sous;
            header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color");
            $_SESSION['temp_finni'] = true;
        }
    }


    include "nav_bar.php";

?>


    <div class="content-wrapper">
        <div class="container">

            <h3 class="page-title"> Mettez votre réponse ici </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index_etudiant.php">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="soumission_etu_par_matiere.php?id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>">Soumission par matière</a></li>
                    <li class="breadcrumb-item"><a href="soumission_etu.php?id_sous=<?php echo $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>">Dètails</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Réponse</li>
                </ol>
            </nav>
            <div class="row">

                <div class="form-horizontal">
                    <p class="erreur_message">
                        <?php
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>

                    </p>
                </div>


                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Description : </label>
                                    <div class="col-md-6">
                                        <textarea id="exampleInputUsername1" name="description_sous" id="" class="form-control" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label>Sélectionnez un fichier : </label>
                                    <div class="col-md-6">
                                        <input type="file" id="fichier" name="file[]" class="form-control" multiple>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <input type="submit" name="button" value="Enregistrer" class="btn btn-primary" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
<?php
} else {
    function test_input($data)
    {
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = stripcslashes($data);
        return $data;
    }

    if (isset($_POST['button'])) {

        $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
        $req3 = mysqli_query($conn, $req_detail3);
        if (mysqli_num_rows($req3) > 0) {
            $descri = test_input($_POST['description_sous']);
            $files = $_FILES['file'];
            if (!empty($descri) or !empty($files)) {
                $sql = "UPDATE reponses set description_rep = '$descri' ,  `date` = NOW() where id_sous = $id_sous and id_etud=(select id_etud from etudiant where email = '$email') ";

                $req1 = mysqli_query($conn, $sql);

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


                        if ($req1 && $req2) {
                            unset($_SESSION['autorisation']);
                            $_SESSION['id_sous'] = $id_sous;
                            $_SESSION['ajout_reussi'] = true;
                            $id_matiere = $_GET['id_matiere'];
                            $color = $_GET['color'];
                            echo " 
                                <script>
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });
                                    Toast.fire({
                                        icon: 'info',
                                        title: 'Cliquer sur la button confirmer votre travail pour enregistree '
                                    });
                                </script>";

                            header("location:reponse_etudiant.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color");
                        } else {
                            mysqli_connect_error();
                        }
                    }
                }
            }
        } else {
            $_SESSION['id_sous'] = $id_sous;
            header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color");
            $_SESSION['temp_finni'] = true;
        }
    }

    if (isset($_POST['confirmer'])) {

        $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
        $req3 = mysqli_query($conn, $req_detail3);
        if (mysqli_num_rows($req3) > 0) {
            $sql = "UPDATE reponses set   `date` = NOW() ,confirmer = 1 where id_sous = $id_sous and id_etud=(select id_etud from etudiant where email = '$email') ";

            $req1 = mysqli_query($conn, $sql);

            if ($req1) {

                $_SESSION['autorisation'] = false;
                unset($_SESSION['autorisation']);
                $id_matiere = $_GET['id_matiere'];
                $color = $_GET['color'];
                $_SESSION['id_sous'] = $id_sous;
                $_SESSION['ajout_reussi'] = true;
                header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color");
            } else {
                echo "il y'a un erreur ! ";
            }
        } else {
            $id_matiere = $_GET['id_matiere'];
            $color = $_GET['color'];
            $_SESSION['id_sous'] = $id_sous;
            header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color");
            $_SESSION['temp_finni'] = true;
        }
    }

    include "nav_bar.php";

    $sql = "SELECT * FROM reponses  WHERE  id_sous = '$id_sous' and id_etud = (select id_etud from etudiant where email = '$email')";
    $req1 = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($req1);

?>
    <div class="content-wrapper">
        <div class="container">
            <h3 class="page-title"> Modifier votre réponse </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index_etudiant.php">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="soumission_etu_par_matiere.php?id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>">Soumission par matière</a></li>
                    <li class="breadcrumb-item"><a href="soumission_etu.php?id_sous=<?php echo $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>">Dètails</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Réponse</li>
                </ol>
            </nav>
            <div class="row">

                <div class="col-md-5 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputUsername1" class="col-md-4">Description : </label>
                                    <textarea id="exampleInputUsername1" name="description_sous" class="form-control" cols="30" rows="10"><?= $row['description_rep'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Sélectionnez un fichier : </label>
                                    <input type="file" id="fichier" name="file[]" class="form-control" multiple>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title">Réponce de l'etudiant à cette soumission.</p>
                            <?php
                            $sql2 = "SELECT * FROM fichiers_reponses, reponses, etudiant WHERE fichiers_reponses.id_rep = reponses.id_rep AND reponses.id_etud = etudiant.id_etud AND email = '$email' AND reponses.id_sous = '$id_sous';";
                            $req2 = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($req2) == 0) {
                            ?>
                                <?php
                                echo "Il n'y a pas de fichier ajouté !";
                                ?>
                                <ul style="list-style: none;">
                                    <?php
                                } else {
                                    while ($row2 = mysqli_fetch_assoc($req2)) {
                                    ?>
                                        <?php
                                        $file_name = $row2['nom_fichiere'];
                                        $id_rep = $row2['id_rep'];
                                        ?>
                                        <blockquote class="blockquote blockquote-info" style="border-radius:10px;">
                                            <p><strong><?= $row2['nom_fichiere'] ?> </strong></p>
                                            <?php
                                            $test = explode(".", $file_name);

                                            $test = explode(".", $file_name);
                                            if ($test[1] == "pdf") {
                                            ?>
                                                &nbsp;<a class="btn btn-inverse-info btn-sm" href="open_file.php?file_name=<?= $file_name ?>&id_rep=<?= $id_rep ?>">Visualiser</a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-inverse-info btn-sm" title="Les fichiers d'extension pdf sont les seuls que vous pouvez visualiser 😒😒.">Visualiser</a>
                                            <?php
                                            }
                                            ?>
                                            <a class="btn btn-inverse-info btn-sm ms-4" href="telecharger_fichier.php?file_name=<?= $file_name ?>&id_rep=<?= $id_rep ?>">Télécharger</a>
                                            <a class="btn btn-inverse-danger btn-sm ms-4" href="supprime_fichier.php?file_name=<?= $file_name ?>&id_sous=<?= $id_sous ?>">Supprimer</a>
                                        </blockquote>
                                        <br>
                                <?php
                                    }
                                }
                                ?>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-md-12" style="display: flex; justify-content: space-between;">
                        <form action="" method="POST">
                        <input type="submit" name="button" value="Enregistrer" class="btn btn-primary" />
                        </form>
                        <button type="submit" name="confirmer" class="btn btn-gradient-danger btn-icon-text"><i class="mdi mdi-upload btn-icon-prepend"></i> Envoyer ton travail</button>
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
        title: 'Suppression réussie !',
        text: 'Le fichier a été supprimé avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

        // Supprimer l'indicateur de succès de la session
        unset($_SESSION['suppression_reussi']);
    }
    if (isset($_SESSION['ajout_reussi']) && $_SESSION['ajout_reussi'] === true) {
        echo "<script>
    Swal.fire({
        title: 'L'enregistrement réussi !',
        text: 'La réponse a été ajoutée avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";
        // Supprimer l'indicateur de succès de la session
        unset($_SESSION['ajout_reussi']);
    }
}
?>

<?php
    if(isset($_POST['button'])){
        echo " 

         <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-start',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: 'info',
                title: 'Cliquer sur la button envoyer ton travail pour enregistree '
            });
        </script>";
    }
 ?>
