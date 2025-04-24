<?php
session_start();
require_once 'config.php'; 

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit();
}

// Recupera le attività dell'utente

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le tue attività</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Le tue attività</h1>
        <?php
// Esegui la query
$idUser = $_SESSION['user_id'];
$query = $pdo->prepare("
    SELECT DISTINCT attivita.*, luogo.nome_luogo, tipo_luogo.tipo_luogo, persona.id_persona
    FROM attivita
    JOIN interesse_attivita ON attivita.id_attivita = interesse_attivita.id_attivita
    JOIN luogo ON luogo.id_parco = attivita.id_luogo
    JOIN tipo_luogo ON tipo_luogo.id_tipo = luogo.id_tipo
    JOIN persona ON persona.id_persona = interesse_attivita.id_persona
    WHERE persona.id_persona = ?
    ORDER BY attivita.nome_attivita;
");
$query->execute([$idUser]);

// Inizia la griglia
echo '<div class="row">';

$counter = 0; // Inizializza il contatore

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    if ($counter % 3 == 0 && $counter != 0) {
        // Chiude la riga corrente e ne inizia una nuova ogni 3 card
        echo '</div><div class="row">';
    }
    
    // Card singola
    echo '<div class="col-md-4 mb-4">';
    echo '  <div class="card">';
    echo '    <div class="card-body">';
    echo '      <h5 class="card-title">'.htmlspecialchars($row['nome_attivita']).'</h5>';
    echo '      <p class="card-text">'.htmlspecialchars($row['nome_luogo']).'</p>';
    echo '      <p class="card-text"><small class="text-muted">'.htmlspecialchars($row['tipo_luogo']).'</small></p>';
    echo '<a href="details.php?id=' . $row['id_attivita'] . '" class="btn btn-success mt-auto mb-3">Maggiori Informazioni</a>';
    echo '
              <form action="insert-Interest.php" method="POST" class="mt-3">
                  <input type="hidden" name="id_Attivita" value="'.htmlspecialchars($row['id_attivita']).'">
                  <input type="hidden" name="tipoAzione" value="remove">  
                  <input type="hidden" name="idUser" value="'.htmlspecialchars($row['id_persona']).'">                      
                  <button type="submit" class="btn btn-danger btn-sm">
                      <i class="bi bi-list-task mb-5"></i>
                      <span>Rimuovi dalla whishlist</span>
                  </button>
              </form>
            ';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';
    
    $counter++; // Incrementa il contatore
}

// Chiude l'ultima riga
echo '</div>';
?>
        
        <div class="text-center mt-4">
            <a href="profile.php" class="btn btn-primary">Torna al tuo profilo</a>
        </div>
    </div>
</body>
</html>