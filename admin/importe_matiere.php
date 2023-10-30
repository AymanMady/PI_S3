<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

 ?>

</br>
</br></br></br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            
            <ol class="breadcrumb">
            <li><a href="#">Acceuil</a>
                    
                    </li>
                    <li>Gestion des matiére</li>
                    <li>importer des matiére</li>
            </ol>
        </div>
    </div>

<div class="form-horizontal">
<br><br>
<form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-md-1">Sélectionner un fichier Excel : </label>
            <div class="col-md-6">
                <input type="file" name="excel" class = "form-control" accept=".xlsx" required>
            </div>
        </div>
		<div class="form-group">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" name="import" value=Importer class="btn-primary"  />
            </div>
        </div>
	</form>
</div>
</div>
		
		<?php
		
		include_once "../connexion.php";

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

				$code = $row[0];
                $libelle = $row[1];
				$semestre = $row[2];
                $specialite = $row[3];
                $module = $row[4];
				
                              
 				$sql = "INSERT INTO matiere( `code`, `libelle`,`id_semestre`,`specialite`, id_module )
								VALUES('$code','$libelle',(SELECT id_semestre FROM semestre WHERE nom_semestre = '$semestre'), '$specialite', (SELECT id_module FROM module WHERE nom_module = '$module'))";
			if(mysqli_query($conn,$sql)){
                		header("location:matiere.php");
        	 }	
			else{
				echo "Ereur lors de l'importation !";
			}
            }


			
		}
		include "../nav_bar.php";
		
		?>
        </div>
	</body>
</html>
