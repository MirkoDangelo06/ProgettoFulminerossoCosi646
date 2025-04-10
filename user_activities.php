<?php
session_start();
require_once 'config.php'; 

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit();
}

// Recupera le attività dell'utente
try {
    $stmt = $pdo->prepare("
    SELECT a.* 
    FROM ATTIVITA a
    JOIN INTERESSE_ATTIVITA ia ON a.id_attivita = ia.id_attivita
    WHERE ia.id_persona = :user_id
    ORDER BY ia.data_iscrizione DESC
    ");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $activities = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Errore nel recupero delle attività: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
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
        
        <?php if (empty($activities)): ?>
            <div class="alert alert-info">
                Non ti sei ancora iscritto a nessuna attività.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($activities as $activity): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($activity['immagine_attivita']) ?>" class="card-img-top" alt="<?= htmlspecialchars($activity['nome_attivita']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($activity['nome_attivita']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($activity['descrizione']) ?></p>
                                <p class="text-muted">Categoria: <?= htmlspecialchars($activity['categoria_attivita']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="text-center mt-4">
            <a href="profile.php" class="btn btn-primary">Torna al tuo profilo</a>
        </div>
    </div>
</body>
</html>