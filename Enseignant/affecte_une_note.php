<?php

session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location:../authentification.php");
}
include_once "../connexion.php";
$id_rep = $_GET['id_etud'];
if (isset($_POST['fin']) && $_POST['Note'] <= 20 && $_POST['Note'] >= 0) {
    $note = $_POST['Note'];
    $sql = "UPDATE `reponses` SET note=$note WHERE id_rep=$id_rep";
    $req_rep = mysqli_query($conn, $sql);
    //$row_rep = mysqli_fetch_assoc($req_rep);
    if ($req_rep) {
        header("location:consiltation_de_reponse.php");
        $_SESSION['id_rep'] = $id_rep;
    }
} else {
    $message = "<p class='text-danger'>Donner une note entre 0 et 20 !😒😒</p>";
}

include "nav_bar.php";
?>

</head>

<body>
    <div class="container">

    </div>
    <?php

    $sql = "select * from reponses where id_rep='$id_rep' ";
    $req = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($req);
    ?>
    <div class="form-horizontal">
        <?php if (isset($_POST['Note']) && $message != "") {
            echo $message;
        }
        ?>
        <form action="" method="POST">
            <div class="form-group">

                <label class="col-md-1" style="font-size: 18px;">Note :</label>
                <div class="col-md-6">
                    <input type="float" name="Note" style="font-size: 22px;" class="form-control" value="<?= $row['note'] ?>">
                </div>
                <div class="col-md-2">
                    <input type="submit" value="affecter" name="fin" class="btn btn-primary p-2 mt-2">
                </div>
        </form>

    </div>
    </div>

    <p>NB : Virgule dans le nombre représentée par un point ( . )</p>
</body>

</html>
<?php

?>