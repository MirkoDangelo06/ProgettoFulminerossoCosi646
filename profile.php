<?php
session_start();
require_once 'config.php';

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $attivita_id = $_POST['attivita_id'];
    $voto = $_POST['voto'];
    $testoRecensione = $_POST['testoRecensione'];
    $dataRecensione = date('Y-m-d');
    $id_persona = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO RECENSIONE (id_persona, id_attivita, voto, testoRecensione, dataRecensione) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_persona, $attivita_id, $voto, $testoRecensione, $dataRecensione]);
        
        $success_message = "Recensione inviata con successo!";
    } catch (PDOException $e) {
        $error_message = "Errore durante l'invio della recensione: " . $e->getMessage();
    }
}

// Recupera tutte le attività disponibili per il dropdown
try {
    $attivita_stmt = $pdo->query("SELECT id_attivita, nome_attivita FROM ATTIVITA");
    $attivita_options = $attivita_stmt->fetchAll();
} catch (PDOException $e) {
    die("Errore nel recupero delle attività: " . $e->getMessage());
}
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profilo Utente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./style.css">
    <style>
        .review-form {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .star-rating {
            font-size: 24px;
            color: #ffc107;
            cursor: pointer;
        }
        .star-rating .bi-star {
            color: #6c757d;
        }
        .btn-purple {
            background-color: #6f42c1;
            color: white;
        }
        .btn-purple:hover {
            background-color: #5a32a3;
            color: white;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!--navbar-->
<div class="w-50 mx-auto">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
<div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="./index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./profile.php">Profilo</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Filtri
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Nessun filtro disponibile</a></li>
                </ul>
            </li>
        </ul>
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</div>
</nav>
</div>

<!--footer up-->
<div class="bg-dark text-white py-4 mb-4 shadow">
    <div class="container">
        <div class="row">
            <h5 class="text-center mb-3">Informazioni aggiuntive su:</h5>
            <h1 class="display-4 text-center mb-0"><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
            <h5 class="mt-2 text-center">(<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</h5>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Form per recensione -->
            <div class="review-form mb-5">
                <h3 class="mb-4 text-center"><i class="bi bi-pencil-square"></i> Lascia una recensione</h3>
                
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php elseif (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="profile.php">
                    <div class="mb-3">
                        <label for="attivita_id" class="form-label">Attività</label>
                        <select class="form-select" id="attivita_id" name="attivita_id" required>
                            <option value="" selected disabled>Seleziona un'attività</option>
                            <?php foreach ($attivita_options as $attivita): ?>
                                <option value="<?php echo $attivita['id_attivita']; ?>"><?php echo htmlspecialchars($attivita['nome_attivita']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Voto</label>
                        <div class="star-rating">
                            <input type="hidden" name="voto" id="rating-value" required>
                            <i class="bi bi-star" data-rating="1"></i>
                            <i class="bi bi-star" data-rating="2"></i>
                            <i class="bi bi-star" data-rating="3"></i>
                            <i class="bi bi-star" data-rating="4"></i>
                            <i class="bi bi-star" data-rating="5"></i>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="testoRecensione" class="form-label">Recensione</label>
                        <textarea class="form-control" id="testoRecensione" name="testoRecensione" rows="3" required></textarea>
                    </div>
                    
                    <button type="submit" name="submit_review" class="btn btn-purple w-100">Invia Recensione</button>
                </form>
            </div>
            
            <!-- Pulsante per vedere le attività -->
            <div class="text-center mt-5">
                <a href="user_activities.php" class="button1 btn btn-primary">
                    <i class="bi bi-list-check"></i> Visualizza le tue attività
                </a>
            </div>
        </div>
    </div>
</div>



<!--offcanvas-->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title me-5" id="offcanvasExampleLabel">Pagina di Login</h5>
        <a href="./loginPage.php" class="btn btn-outline-secondary ms-3">Login</a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr>
    <div class="offcanvas-body">
        <div>
            <p>La nostra vision: creare il sito di informazione e prenotazione eventi più famoso e conosciuto,
                scopri chi siamo e dove vogliamo arrivare: 
            </p> 
        </div>
        <!-- Cards rimangono uguali -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sistema di valutazione a stelle
    document.querySelectorAll('.star-rating i').forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            document.getElementById('rating-value').value = rating;
            
            // Aggiorna l'aspetto delle stelle
            document.querySelectorAll('.star-rating i').forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill');
                } else {
                    s.classList.remove('bi-star-fill');
                    s.classList.add('bi-star');
                }
            });
        });
    });
</script>
</body>
</html>