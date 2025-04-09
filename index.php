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
  <form>  
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
          echo '<a href="details.php?id=' . $row['id_attivita'] . '" class="btn button1">Maggiori Informazioni</a>';
          echo '    </div>';
          echo '  </div>';
          echo '</div>';
          $counter ++;
        }
        // Chiudi l'ultima riga e il container
        echo '</div>';
        ?>
    </div><!-- chiusura container -->
  <form>     
</div><!-- chiusura del div principale -->






<!-- Footer Section -->
<footer class="bg-dark text-light py-3 mt-5">
    <div class="container">
      <div class="row g-4"> <!-- Aggiunto gutter tra le colonne -->
        <!-- Sponsors Section -->
        <div class="col-md-4 mb-4">
          <div class="h-100 p-3"> <!-- Contenitore interno con padding -->
            <h5 class="text-uppercase mb-4 border-bottom pb-2">I Nostri Sponsor</h5> <!-- Aumentato spazio e aggiunto bordo -->
            <div class="d-flex justify-content-center gap-4"> <!-- Centratura e spazio tra logo -->
              <div class="sponsor-logo">
                <img src="https://www.ctelift.com/wp-content/uploads/2017/07/Logo-Gardaland.jpg" alt="Gardaland" class="img-fluid rounded">
              </div>
              <div class="sponsor-logo">
                <img src="https://www.liukdesign.net/wp-content/uploads/2023/07/wd-logo2.jpg" alt="Disneyland" class="img-fluid rounded">
              </div>
            </div>
          </div>
        </div>

        <!-- Partnerships Section -->
        <div class="col-md-4 mb-4">
          <div class="h-100 p-3">
            <h5 class="text-uppercase mb-4 border-bottom pb-2">Le Nostre Partnership</h5>
            <div class="d-flex justify-content-center gap-3 flex-wrap"> <!-- Flex-wrap per responsive -->
              <div class="partnership-logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTkcg81bScWR3PIsca4apHbd5Vf8xNp8EJKLw&s" alt="Escursioni Trentino" class="img-fluid rounded">
              </div>
              <div class="partnership-logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCCiEDrmKtK__oQsJQ9SSwDFX66PM_Oursew&s" alt="Disney Parks" class="img-fluid rounded">
              </div>
              <div class="partnership-logo">
                <img src="https://play-lh.googleusercontent.com/y_PbrLR8iRL6gAjeNhyM7GtZDVQfc-lZ_bwo-4ecmrLEObYeW6Ss0lDGUR0Yc9EvkVI8" alt="Parco Zoomarine" class="img-fluid rounded">
              </div>
            </div>
          </div>
        </div>

        <!-- Links Section -->
        <div class="col-md-4 mb-4">
          <div class="h-100 p-3">
            <h5 class="text-uppercase mb-4 border-bottom pb-2">Link Utili</h5>
            <ul class="list-unstyled ps-3"> <!-- Padding sinistro -->
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Crediti</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Privacy e Cookie</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Termini di Servizio</a></li>
              <li><a href="#" class="text-light text-decoration-none hover-underline">Contattaci</a></li>
            </ul>
          </div>
        </div>
      </div>



    <!-- Prima della chiusura del footer, aggiungi questa sezione -->
<div class="row ">
  <div class="col-12 text-center">
    <div class="credits-container py-2">
      <span class="credits-text">Sviluppato  da</span>
      <div class="d-flex justify-content-center gap-4 mt-2">
        <a href="#" class="credit-badge" data-name="Cosimo Bassi">
          <span class="credit-name">Cosimo Bassi</span>
        </a>
        <span class="text-muted">&</span>
        <a href="#" class="credit-badge" data-name="Mirko D'Angelo">
          <span class="credit-name">Mirko D'Angelo</span>
        </a>
      </div>
    </div>
  </div>
</div>

</footer>


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
     <hr>
    </div>
    <div class="dropdown mt-3">
      <!-- Card 1 -->
      <div class="col-md-4 mt-5">
        <div class="card" style="width: 18rem;">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSq3PCoO2a-Bp_8rpEqJ7yaxvMNfVWt6eAEKA&s" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">Essere sempre aggiornati</h5>
               
            </div>
        </div>
    </div>

    <hr>

      <!-- Card 2 -->
      <div class="col-md-4 mt-3">
        <div class="card" style="width: 18rem;">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQqXAiq_Fe5Dyjb5aBLtkl7z2IyY_1bGlxeQ&s" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">Scoprire le promozioni</h5>
            </div>
        </div>
    </div>

    <hr>

      <!-- Card 3 -->
      <div class="col-md-4 mt-3">
        <div class="card" style="width: 18rem;">
            <img src="https://img.freepik.com/foto-gratuito/bambini-che-giocano-su-erba_1098-504.jpg" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">Anche per i piu piccoli</h5>
           
            </div>
        </div>
    </div>
    </div>
  </div>

                                                                                                                             


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="js/video-handler.js"></script> 
    
  </body>
</html>