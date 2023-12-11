<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
include_once "nav_bar.php";
?>

<title>Importer des etudiants</title>

<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Importer des etudiants : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Sélectionner un fichier Excel :</label>
						<input type="file" name="excel" class="form-control" accept=".xlsx" required>
                      </div>
					  <input type="submit" name="import" value="Importer" class="btn btn-gradient-primary me-2"  />
                      <a href="etudiant.php" class="btn btn-light">Annuler</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>


<?php
include_once "../connexion.php";


function test_input($data){
	$data = htmlspecialchars($data);
	$data = trim($data);
	$data = htmlentities($data);
	$data = stripcslashes($data);

	return $data;
}


if (isset($_POST["import"])) {

	$fileName = $_FILES["excel"]["name"];
	$fileExtension = explode('.', $fileName);
	$fileExtension = strtolower(end($fileExtension));
	$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

	$targetDirectory = "uploads/" . $newFileName;
	move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

	error_reporting(0);
	ini_set('display_errors', 0);

	require 'excelReader/excel_reader2.php';
	require 'excelReader/SpreadsheetReader.php';

	$reader = new SpreadsheetReader($targetDirectory);
	foreach ($reader as $key => $row) {


		$matricule = test_input($row[0]);
		$nom = test_input($row[1]);
		$prenom = test_input($row[2]);
		$lieu_naiss = test_input($row[3]);
		$Date_naiss = test_input($row[4]);
		$semestre = test_input($row[5]);
		$annee = test_input($row[6]);
		$email = test_input($row[7]);
		$groupe = test_input($row[8]);
		$departement = test_input($row[9]);

		if(mysqli_query($conn, "INSERT INTO etudiant
		(`matricule`, `nom`, `prenom`, `lieu_naiss`, `Date_naiss`, `id_semestre`, `annee`, `email`,`id_role`, `id_groupe`, `id_dep` ) VALUES
		('$matricule', '$nom','$prenom', '$lieu_naiss','$Date_naiss', 
		(select id_semestre from semestre where nom_semestre = '$semestre'  LIMIT 1), '$annee','$email',3,
		(SELECT id_groupe FROM groupe WHERE libelle = '$groupe'  LIMIT 1),
		(SELECT id FROM departement WHERE code = '$departement'  LIMIT 1) )")){
			echo "<script>window.location.href = 'etudiant.php';</script>";
		}	
		}


	}

	
	?>

