<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

   
  
  </head>
  <body class="  d-flex flex-column min-vh-100">

<!--errore logout-->
  <?php
  session_start();
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Logout effettuato con successo!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
  ?>


  <!--VIDEO-->
  <div id="splash-screen">
        <video autoplay muted playsinline id="splash-video">
            <source src="./video/intro3.mp4" type="video/mp4">
            Il tuo browser non supporta il tag video.
        </video>
    </div>


    
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
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          
          <?php if(!isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
              Login
            </a>
          </li>
          <?php endif; ?>

          <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="profile.php" role="button">
              Il tuo profilo
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php" role="button">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </li>
          <?php endif; ?>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Filtri
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Per data</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Per tipo attività</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Per luogo</a></li>
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


<!--grid-->
<div class="mt-5 w-75 mx-auto my-auto">
  <div class="container"> <!-- inizio della griglia con le card delle attività -->     
    <?php  
      (include "./connessione.php");//inclusione del file di connessione
      echo '<div class="row">';//prima riga della griglia
      $query = $conn->query("SELECT * FROM attivita");
      $counter = 0;
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        if ($counter % 3 == 0 && $counter != 0) { // se si sono superate le 3 card chiude la vecchia linea e ne crea una nuova
          echo '</div><div class="row">';
        }
        
        // Genera la card con i contenuti della tabella attivita
        echo '<div class="col-md-4 mb-4 ">';
        echo '  <div class="card" style="width: 18rem;">';
        echo '<img src="' . htmlspecialchars($row['immagine_attivita']) . '" class="card-img-top">';
        echo '    <div class="card-body">';
        echo '      <h5 class="card-title">' . htmlspecialchars($row['nome_attivita']) . '</h5>';
        echo '      <p class="card-text">' . htmlspecialchars($row['descrizione']) . '</p>';
        echo '      <a href="#" class="btn btn-success">Maggiori Informazioni</a>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
        $counter ++;
      }
      // Chiudi l'ultima riga e il container
      echo '</div>';

      ?>
  </div><!-- chiusura container -->     
</div>

<!-- Footer Section -->
<footer class="bg-dark text-light py-5 mt-5">
  <div class="container">
    <div class="row">
      <!-- Sponsors Section -->
      <div class="col-md-4 mb-4">
        <h5 class="text-uppercase mb-3">I Nostri Sponsor</h5>
        <div class="d-flex justify-content-between">
          <!-- Sponsor 1 -->
          <div class="sponsor-logo">
            <img src="https://via.placeholder.com/120x60?text=Gardaland" alt="Gardaland" class="img-fluid">
          </div>
          <!-- Sponsor 2 -->
          <div class="sponsor-logo">
            <img src="https://via.placeholder.com/120x60?text=Disneyland" alt="Disneyland" class="img-fluid">
          </div>
          <!-- Sponsor 3 -->
          <div class="sponsor-logo">
            <img src="https://via.placeholder.com/120x60?text=Trentino" alt="Trentino" class="img-fluid">
          </div>
        </div>
      </div>

      <!-- Partnerships Section -->
      <div class="col-md-4 mb-4">
        <h5 class="text-uppercase mb-3">Le Nostre Partnership</h5>
        <div class="d-flex justify-content-between">
          <!-- Partnership 1 -->
          <div class="partnership-logo">
            <img src="https://via.placeholder.com/120x60?text=Escursioni+Trentino" alt="Escursioni Trentino" class="img-fluid">
          </div>
          <!-- Partnership 2 -->
          <div class="partnership-logo">
            <img src="https://via.placeholder.com/120x60?text=Disney+Parks" alt="Disney Parks" class="img-fluid">
          </div>
          <!-- Partnership 3 -->
          <div class="partnership-logo">
            <img src="https://via.placeholder.com/120x60?text=Parco+Zoomarine" alt="Parco Zoomarine" class="img-fluid">
          </div>
        </div>
      </div>

      <!-- Links Section -->
      <div class="col-md-4 mb-4">
        <h5 class="text-uppercase mb-3">Link Utili</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-light text-decoration-none">Crediti</a></li>
          <li><a href="#" class="text-light text-decoration-none">Privacy e Cookie</a></li>
          <li><a href="#" class="text-light text-decoration-none">Termini di Servizio</a></li>
          <li><a href="#" class="text-light text-decoration-none">Contattaci</a></li>
        </ul>
      </div>
    </div>

    <!-- Footer Bottom Section -->
    <div class="row mt-4">
      <div class="col-12 text-center">
        <p class="mb-0">&copy; 2025 Prenotazioni Attività. Tutti i diritti riservati.</p>
      </div>
    </div>
  </div>
</footer>



</div>









<!--offcanvas---->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title me-5" id="offcanvasExampleLabel"> pagina di Login</h5>
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
    <div class="dropdown mt-3">
      <!-- Card 1 -->
      <div class="col-md-4 mt-5">
        <div class="card" style="width: 18rem;">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">Card 4</h5>
                <p class="card-text">Questa è la quarta card.</p>
            </div>
        </div>
    </div>

    <hr>

      <!-- Card 2 -->
      <div class="col-md-4 mt-3">
        <div class="card" style="width: 18rem;">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">Card 4</h5>
                <p class="card-text">Questa è la quarta card.</p>
            </div>
        </div>
    </div>

    <hr>

      <!-- Card 3 -->
      <div class="col-md-4 mt-3">
        <div class="card" style="width: 18rem;">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">Card 4</h5>
                <p class="card-text">Questa è la quarta card.</p>
            </div>
        </div>
    </div>
    </div>
  </div>

                                                                                                                             


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/video-handler.js"></script> 
    
  </body>
</html>