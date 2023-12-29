<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        tr:hover {
            cursor: pointer;
            background-color: aliceblue;
        }

        .div-hover:hover {
            background-color: #dfe9f7;
            background-color: <?= $color_hover; ?>;
            cursor: pointer;
        }

        .div-hover {
            border: 1px solid rgb(209, 206, 206);
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    if (isset($_GET["id_matiere"])) {
        $_SESSION['id_matirer'] = $_GET["id_matiere"];
    }
    $id_matiere = $_SESSION['id_matirer'];
    $email = $_SESSION['email'];

    if ($_SESSION["role"] != "ens") {
        header("location:authentification.php");
    }

    if (isset($_GET["color"])) {
        $_SESSION['color'] = $_GET["color"];
    }
    $color = $_SESSION['color'];

    if (isset($_GET["color_hover"])) {
        $_SESSION['color_hover'] = $_GET["color_hover"];
    }
    $color_hover = $_SESSION["color_hover"];

    include_once "../connexion.php";
    include "nav_bar.php";

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

    $req1 = mysqli_query($conn, $req_sous1);

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

    $req2 = mysqli_query($conn, $req_sous2);

    $ens = "SELECT DISTINCT matiere.* FROM matiere where id_matiere= $id_matiere";
    $matiere_filtre_qry = mysqli_query($conn, $ens);
    $row_mat = mysqli_fetch_array($matiere_filtre_qry);

    $type_sous = "SELECT * FROM type_soumission";
    $type_sous_qry = mysqli_query($conn, $type_sous);
    ?>
    <div class="content-wrapper">
        <div class="content">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-home"></i>
                    </span>
                    <a href="choix_semester.php">Accueil</a><?php echo " / " ?><a
                        href="index_enseignant.php?id_semestre=<?php echo $_SESSION['id_semestre']; ?>"><?php echo "S" . $_SESSION['id_semestre']; ?></a><?php echo " / " ?><a
                        href="#"><?php echo $row_mat['libelle'] ?></a>
                    <?php $_SESSION['libelle'] = $row_mat['libelle'] ?>
                </h3>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-12 stretch-card grid-margin">
                        <div class="card bg-gradient-<?php echo $color ?> card-img-holder text-white">
                            <div class="card-body ">
                                <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute"
                                    alt="circle-image" />
                                <h4 class="mb-5"><?= $row_mat['libelle'] . " " ?></h4>
                                <h6 class="click"></h6>
                                <div class="md-2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    while ($row = mysqli_fetch_assoc($req1)) {
                    ?>
                                            <div class="col-md-14 stretch-card grid-margin">
                            <div class="card bg-gradient card-img-holder text-black" id="tou"onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)">
                                <div class="card-body div-hover" class="div-hover" style="display: flex;justify-content: left;padding: 15px; ">
                                    <div class="btn-gradient-info" style="width: 37px;border-radius: 100%;height: 40px;display: flex;justify-content: center;align-items: center;margin-right: 10px;" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)">
                                        <i class="mdi mdi-book-open-page-variant " style="font-size: 20px;"></i>
                                    </div>
                                    <div >
                                        <p class="m-0"><?= $row['nom'] . " " . $row['prenom'] ?> a publié un nouveau <?= $row['titre_sous'] ?> </p>
                                        <p style="margin: 0%;">De &nbsp;<?= $row['date_debut'] ?> &nbsp; à &nbsp; <?= $row['date_fin']  ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        
            <script src="../JS/sweetalert2.js"></script>
            <script>
                function redirectToDetails(id_matiere) {
                    window.location.href = "reponses_etud.php?id_sous=" + id_matiere;
                }
            </script>
            <script>
                var liensArchiver = document.querySelectorAll("#archiver");
        
                liensArchiver.forEach(function (lien) {
                    lien.addEventListener("click", function (event) {
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
        
                var liensCloturer = document.querySelectorAll("#cloturer");
        
                liensCloturer.forEach(function (lien) {
                    lien.addEventListener("click", function (event) {
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
        
                function modifierDateFin(id_sous, nouvelle_date_fin) {
                    var formData = new FormData();
                    formData.append('id_sous', id_sous);
                    formData.append('nouvelle_date_fin', nouvelle_date_fin);
        
                    fetch('modifier_date_fin.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire({
                                    title: 'Succès',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#3099d6'
                                });
                            } else {
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
        