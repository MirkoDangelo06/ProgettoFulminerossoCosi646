<?php
session_start();
require_once 'config.php'; 

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit();
}

// Recupera le recensioni dell'utente con i dettagli delle attività
try {
    $stmt = $pdo->prepare("
    SELECT r.*, a.nome_attivita, a.immagine_attivita, a.descrizione 
    FROM RECENSIONE r
    JOIN ATTIVITA a ON r.id_attivita = a.id_attivita
    WHERE r.id_persona = :user_id
    ORDER BY r.dataRecensione DESC
    ");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $reviews = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Errore nel recupero delle recensioni: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le tue recensioni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .review-card {
            border-left: 4px solid #6f42c1;
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .star-rating {
            color: #ffc107;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .activity-img {
            height: 200px;
            object-fit: cover;
            border-radius: 5px 5px 0 0;
        }
        .no-reviews {
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .review-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

              /*font personalizzati */
      @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap');
      @import url('https://fonts.googleapis.com/css2?family=Inter:slnt,wght@-10..0,100..900&display=swap');

        .orbitron-bold {
            font-family: "Orbitron", sans-serif;
            font-weight: 500;
        }

        .inter-paragrafi {
            font-family: "Inter", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 250; 
        }

        .card-dimensione-fissa {
        width: 280px; /* o usa %, vw, ecc. */
        height: 380px;
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* per allineare testo e bottone */
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <div style="background-color: #2D3748">
        <h1 class="text-center mb-4 text-light mt-3 ">Le tue recensioni</h1>
    </div>
        

    <div class="container mt-5">
       
        <?php if (empty($reviews)): ?>
            <div class="alert alert-info no-reviews">
                <i class="bi bi-chat-square-text" style="font-size: 2rem;"></i>
                <p class="mt-3">Non hai ancora lasciato nessuna recensione.</p>
                <a href="profile.php" class="btn btn-primary mt-2">Lascia una recensione</a>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($reviews as $review): ?>
                    <div class="col-md-6">
                        <div class="card review-card h-100">
                            <img src="<?= htmlspecialchars($review['immagine_attivita']) ?>" class="card-img-top activity-img" alt="<?= htmlspecialchars($review['nome_attivita']) ?>">
                            <div class="card-body">
                                <h4 class="card-title"><?= htmlspecialchars($review['nome_attivita']) ?></h4>
                                <div class="star-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="bi bi-star<?= $i <= $review['voto'] ? '-fill' : '' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="ms-2"><?= $review['voto'] ?>/5</span>
                                </div>
                                <p class="card-text"><?= nl2br(htmlspecialchars($review['testoRecensione'])) ?></p>
                                <p class="review-date">
                                    <i class="bi bi-calendar"></i> 
                                    <?= date('d/m/Y', strtotime($review['dataRecensione'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="text-center mt-4 mb-5">
            <a href="profile.php" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Torna al tuo profilo
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>