<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inserimento-interesse-Attivita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
<?php
     include "./connessione.php";
     $idUserINS = $_POST['idUser'];
     $id_attivitaINS = $_POST['id_Attivita'];
     $chosenAction = $_POST['tipoAzione'];
     if($chosenAction == "add"){
        $queryInteresse = $conn->query("INSERT INTO `attivitadb`.`interesse_attivita` (`id_persona`, `id_attivita`, `data_iscrizione`) VALUES ('$idUserINS', '$id_attivitaINS', CURRENT_DATE())");
        //echo '<div class="alert alert-success mt-2">Attività aggiunta alla wishlist!</div>';
        header("Location: user_activities.php");//redirect alla pagina contenente la whishlist
        exit; 
     }else if($chosenAction == "remove"){
        $conn->query("DELETE FROM interesse_attivita WHERE id_persona = '$idUserINS' AND id_attivita = '$id_attivitaINS'");
        //echo '<div class="alert alert-warning mt-2">Attività rimossa dalla wishlist!</div>';
        header("Location: user_activities.php");
        exit;
     }

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>
</html>
