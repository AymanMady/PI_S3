<?php
include_once "../connexion.php";

    $file_name = $_GET['file_name'];
    $id_rep = $_GET['id_rep'];
    $id_sous = $_GET['id_sous'];
    if(isset($id_rep)){
        $sql2 = "select * from fichiers_reponses where id_rep='$id_rep' and nom_fichiere='$file_name' ";
        $req2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($req2);
        $file_chemin = $row2['chemin_fichiere']; 
    }else{
        $sql2 = "select * from fichiers_soumission where id_sous='$id_sous' and nom_fichier='$file_name' ";
        $req2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($req2);
        $file_chemin = $row2['chemin_fichier']; 
    }
    $file_extension = pathinfo($file_chemin, PATHINFO_EXTENSION);
    $content_type = '';

   
    switch ($file_extension) {
        case 'pdf':
            $content_type = 'application/pdf';
            break;
        case 'doc':
        case 'docx':
            $content_type = 'application/vnd.ms-word';
            break;
        case 'xls':
        case 'xlsx':
            $content_type = 'application/vnd.ms-excel';
            break;
        case 'odt':
            $content_type = 'application/vnd.oasis.opendocument.text';
            break;
        case 'txt':
            $content_type = 'text/plain';
            break;
        default:
            // Type de fichier non pris en charge
            die('Erreur : type de fichier non pris en charge');
    }
    
    // Envoi des en-têtes HTTP pour le téléchargement
    header("Content-Type: {$content_type}");
    header("Content-Disposition: attachment; filename=\"{$file_name}\"");
    header("Content-Transfer-Encoding: binary");
    header("Accept-Ranges: bytes");
    
    // Lecture du fichier et envoi de son contenu
    readfile($file_chemin);
    exit;
?>