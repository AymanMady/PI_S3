<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}

include_once "nav_bar.php";
include_once "../connexion.php";
$id_matiere = $_GET['id_matiere'];
$sql1 = "select * from matiere where id_matiere=$id_matiere";
$sql2 = mysqli_query($conn, $sql1);
$row1 =  mysqli_fetch_assoc($sql2);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
        #tou:hover {
            cursor: pointer;
            background-color: aliceblue;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <style>
        .div-hover:hover {
            background-color: #dfe9f7;
            cursor: pointer; /* Changer le curseur de la souris */
        }

        .div-hover {
            border: 1px solid rgb(209, 206, 206);
            border-radius: 5px;
        }

 */
    </style>

    <div class="main-panel">
        <div class="content-wrapper">

            <!-- partial:partials/_navbar.html -->

            <?php
            $color = $_GET['color'];
            $enline = "outline-dark";
            $cloture = "outline-dark";

            $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and  (status=0  status=1) and date_debut <= Now()";
            $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and  (status=0 or status=1) and date_debut <= Now()";

            if (isset($_POST['cloture'])) {
                $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and  status=1 and date_debut <= Now()";
                $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and   status=1 and date_debut <= Now()";
                $enline = "outline-dark";
                $cloture = "dark";
            } else if (isset($_POST['enline'])) {
                $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and  status=0 and date_debut <= Now()";
                $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and status=0   and date_debut <= Now()";

                $enline = "dark";
                $cloture = "outline-dark";
            }
            ?>

            <h3 class="page-title"> Les soumissions dans le matière <?php echo "" . $row1['libelle'] . "" . " " ?></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index_etudiant.php">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo "" . $row1['libelle'] . "" . " " ?></li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-3.5 stretch-card grid-margin">
                    <div class="card bg-gradient-<?php echo $color ?> card-img-holder text-white">
                        <div class="card-body">
                            <h4 class="mb-5">  <?php echo " " . $row1['libelle'] . "" . " ";$_SESSION['nom_mat']=$row1['libelle']; ?></h4>
                            <form method="post">
                                <input type="submit" id="statu" class="btn btn-<?php echo $enline ;?> p-2" name="enline" value="Les soumissions en ligne">
                                <input type="submit" id="statu" class="btn btn-<?php echo $cloture ;?> p-2 " name="cloture" value="Les soumissions terminées">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $req = mysqli_query($conn, $req_detail);
            if (mysqli_num_rows($req) > 0) {

                while ($row = mysqli_fetch_assoc($req)) {
                    $m = $row['id_ens'];
                    $sqt = "select * from enseignant where id_ens='$m'";
                    $red = mysqli_query($conn, $sqt);
                    $rot = mysqli_fetch_assoc($red);
                    ?>
                    <tr>
                        <?php
                    ?>
                    <div class="col-md-14 stretch-card grid-margin">
                        <div class="card bg-gradient card-img-holder text-black" id="tou">
                            <div class="card-body div-hover" class="div-hover" style="display: flex;justify-content: left;padding: 15px; ">
                                <div class="btn-gradient-info" style="width: 37px;border-radius: 100%;height: 40px;display: flex;justify-content: center;align-items: center;margin-right: 10px;" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)">
                                    <i class="mdi mdi-book-open-page-variant " style="font-size: 20px;"></i>
                                </div>
                                <div onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)">
                                    <p class="m-0"><?= $rot['nom'] . " " . $rot['prenom'] ?> a publié un nouveau  <?= $row['titre_sous'] ?> </p>
                                    <p style="margin: 0%;">De &nbsp;<?= $row['date_debut'] ?> &nbsp; à &nbsp;  <?= $row['date_fin']  ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>

                <?php
                }

            } else {
                ?>
                <div class="col-md-14 stretch-card grid-margin">
                    <div class="card bg-gradient card-img-holder text-black" id="tou" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)">
                        <div class="card-body div-hover" class="div-hover" style="display: flex;justify-content: left;padding: 15px; ">
                            <div class="btn-gradient-info" style="width: 37px;border-radius: 100%;height: 40px;display: flex;justify-content: center;align-items: center;margin-right: 10px;">
                                <i class="mdi mdi-book-open-page-variant " style="font-size: 20px;"></i>
                            </div>
                            <div>
                                <p class="m-0"> Il n'y a pas de soumissions </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    </div>
    </div>
    <!-- partial:partials/_footer.html -->
    \
    <!-- partial -->
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->

    <script>
        function redirectToDetails(id_sous, id_matiere, color) {
            window.location.href = "soumission_etu.php?id_sous=" + id_sous + "&id_matiere=" + id_matiere + "&color=" + color;
        }
    </script>
