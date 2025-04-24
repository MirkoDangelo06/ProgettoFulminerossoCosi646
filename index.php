<?php
(include "./connessione.php");//inclusione del file di connessione
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProgettoInformatica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <style>
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
    .card-dimensione-fissa img {
      height: 200px;
      object-fit: cover;
    }
  </style>
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
  <!--
  <div id="splash-screen">
        <video autoplay muted playsinline id="splash-video">
            <source src="./video/nuovaIntro.mp4" type="video/mp4">
            Il tuo browser non supporta il tag video.
        </video>
    </div>
  -->

 <!--navbar-->
 <div class="w-100 mx-auto">
  <nav class="navbar navbar-expand-lg text-clear" style="background-color: #2D3748;">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="./images/stoCoseDafarelogo.png"  height="80">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active text-white" aria-current="page" href="index.php">Home</a>
          </li>

          <?php if(!isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
              Login
            </a>
          </li>
          <?php endif; ?>

          <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="profile.php" role="button">
              Il tuo profilo
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php" role="button">
              <i class="bi bi-box-arrow-right text-white"></i> Logout
            </a>
          </li>
          <?php endif; ?>

        <!-- Dropdown Filtri -->
        <div class="ms-auto me-3">
          <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="filtriDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-sliders"></i> Filtri
            </button>
            
            <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 280px;" aria-labelledby="filtriDropdown">
              <!-- Filtro Regione -->
              <form action="search.php" method="POST" class="mb-3">
                <input type="hidden" name="tipoRicerca" value="filtroRegioni">
                <div class="input-group">
                  <select class="form-select form-select-sm" name="regioneSelect" aria-label="Filtra per regione">
                    <option selected value="">Scegli una regione</option>
                    <?php
                    $queryRegione = $conn->query("SELECT DISTINCT locazione.regione FROM locazione ORDER BY regione ASC");              
                    while ($row = $queryRegione->fetch(PDO::FETCH_ASSOC)){
                      echo '<option value="' . htmlspecialchars($row['regione']) . '">' . htmlspecialchars($row['regione']) . '</option>';
                    }
                    ?>
                  </select>
                  <button class="btn btn-success btn-sm" type="submit">
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </form>

              <!-- Filtro Parco-->
              <form action="search.php" method="POST" class="mb-3">
                <input type="hidden" name="tipoRicerca" value="filtroLuoghi">
                <div class="input-group">
                  <select class="form-select form-select-sm" name="luoghiSelect" aria-label="Filtra per parco">
                    <option selected value="">Scegli un luogo</option>
                    <?php
                    $queryRegione = $conn->query("SELECT DISTINCT luogo.nome_luogo, luogo.id_parco FROM luogo");              
                    while ($row = $queryRegione->fetch(PDO::FETCH_ASSOC)){
                      echo '<option value="' . htmlspecialchars($row['id_parco']) . '">' . htmlspecialchars($row['nome_luogo']) . '</option>';
                    }
                    ?>
                  </select>
                  <button class="btn btn-success btn-sm" type="submit">
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </form>

              <!-- Filtro Tipo Attività  -->
              <form action="search.php" method="POST">
                <input type="hidden" name="tipoRicerca" value="filtroTipo">
                <div class="input-group">
                  <select class="form-select form-select-sm" name="tipoSelect" aria-label="Filtra per tipo">
                    <option selected value="">Scegli un tipo di luogo</option>
                    <?php
                    $queryRegione = $conn->query("SELECT DISTINCT * FROM tipo_luogo");              
                    while ($row = $queryRegione->fetch(PDO::FETCH_ASSOC)){
                      echo '<option value="' . htmlspecialchars($row['id_tipo']) . '">' . htmlspecialchars($row['tipo_luogo']) . '</option>';
                    }
                    ?>
                  </select>
                  <button class="btn btn-success btn-sm" type="submit">
                    <i class="bi bi-search"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!--barra di ricerca-->
        <form class="d-flex" action="search.php" method="POST">
          <input class="form-control me-2" type="search" name="valoreDaCercare" placeholder="Cosa stai cercando..." aria-label="Search" required>
          <input type="hidden" name="tipoRicerca" value="ricerca">
          <button class="btn btn-success" type="submit">Search</button>
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
        echo '<div class="row">';//prima riga della griglia
        $query = $conn->query("SELECT * FROM attivita join luogo on attivita.id_luogo = luogo.id_parco");
        $counter = 0;
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
          if ($counter % 3 == 0 && $counter != 0) { // se si sono superate le 3 card chiude la vecchia linea e ne crea una nuova
            echo '</div><div class="row">';
          }
          
          // Genera la card con i contenuti della tabella attivita
          echo '<div class="col-md-4 mb-4 ">';
          echo '  <div class="card card-dimensione-fissa d-flex flex-column" style="width: 18rem;">';
          echo '<img src="' . htmlspecialchars($row['immagine_attivita']) . '" class="card-img-top object-fit-cover img-fluid">';
          echo '    <div class="card-body d-flex flex-column">';
          echo '<h5 class="card-title orbitron-bold ">' . htmlspecialchars($row['nome_attivita']) . '</h5>';
          echo '<p class="card-content inter-paragrafi">' . htmlspecialchars($row['nome_luogo']) . '</p>';
          echo '<a href="details.php?id=' . $row['id_attivita'] . '" class="btn button2 mt-auto mb-3">Maggiori Informazioni</a>';
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
<footer class="text-light py-3 mt-5" style="background-color: #2D3748;">
    <div class="container">
      <div class="row g-4">
        <!-- Sponsors Section - Modificata per 9 sponsor in griglia 3x3 -->
        <div class="col-md-4 mb-4">
          <div class="h-100 p-3">
            <h5 class="text-uppercase mb-4 border-bottom pb-2">Sponsor</h5>
            <div class="row g-3"> 
              <!-- Prima riga -->
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRJ3VXnlOjUruKy3rotp8-jIbORuzTJCQIvuA&s" alt="canyon" class="img-fluid rounded">
                </div>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://storage.googleapis.com/media-bici-pro/1/2024/03/img_dkdec1.jpg" alt="decathlon" class="img-fluid rounded">
                </div>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://1000logos.net/wp-content/uploads/2021/04/Red-Bull-logo.png" alt="RedBull" class="img-fluid rounded">
                </div>
              </div>
              
              <!-- Seconda riga -->
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRORmyrON-G7Iron3nQcC9H01C24IinMg_tcQ&s" alt="sudtirol" class="img-fluid rounded">
                </div>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://payload.cargocollective.com/1/2/69280/12934813/GoPro_Brand_Refresh_Logo_Large_4CR_v2_1280.jpg" alt="Sponsor 5" class="img-fluid rounded">
                </div>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT1oXqtdU1NBxtwvf4aK4IXt4nCGrHeurVMWA&s" alt="Sponsor 6" class="img-fluid rounded">
                </div>
              </div>
              
              <!-- Terza riga -->
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://cdn-cf.cms.flixbus.com/drupal-assets/ogimage/flixbus.png" alt="Sponsor 7" class="img-fluid rounded">
                </div>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTgEp3Ut8sF_SNNclDX6LZbYjtyLPB2jevrZQ&s" alt="Sponsor 8" class="img-fluid rounded">
                </div>
              </div>
              <div class="col-4 d-flex justify-content-center">
                <div class="sponsor-logo">
                  <img src="https://www.itineraridicinemaedamerica.com/wp-content/uploads/2013/07/booking-com-logo.jpg" alt="Sponsor 9" class="img-fluid rounded">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Partnerships Section-->
        <div class="col-md-4 mb-4">
          <div class="h-100 p-3">
            <h5 class="text-uppercase mb-4 border-bottom pb-2">Le Nostre Partnership</h5>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
              <div class="partnership-logo">
                <img src="https://media.licdn.com/dms/image/v2/D4D22AQH9QUi355cI8w/feedshare-shrink_800/B4DZTKzP2zHIAg-/0/1738569220905?e=2147483647&v=beta&t=EWSyRV2CDKS27nxuAndwKGG9kB_YWDGua86qquatd_I" alt="gardaland" class="img-fluid rounded">
              </div>
              <div class="partnership-logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQCCiEDrmKtK__oQsJQ9SSwDFX66PM_Oursew&s" alt="Disney Parks" class="img-fluid rounded">
              </div>
              <div class="partnership-logo">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIh1lTg00Ml29Hk96LyP_5cK8zTG1Bl70UQQ&s" alt="Cavallino Matto" class="img-fluid rounded">
              </div>
            </div>
          </div>
        </div>

        <!-- Links Section-->
        <div class="col-md-4 mb-4">
          <div class="h-100 p-3">
            <h5 class="text-uppercase mb-4 border-bottom pb-2">Link Utili</h5>
            <ul class="list-unstyled ps-3">
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Crediti</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Privacy e Cookie</a></li>
              <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Termini di Servizio</a></li>
              <li><a href="#" class="text-light text-decoration-none hover-underline">Contattaci</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Credits Section (invariata) -->
      <div class="row">
        <div class="col-12 text-center">
          <div class="credits-container py-2">
            <span class="credits-text">Sviluppato da</span>
            <div class="d-flex justify-content-center gap-4 mt-2">
              <a href="#" class="credit-badge" data-name="Cosimo Bassi">
                <span class="credit-name">COSI646</span>
              </a>
              <span class="text-muted">&</span>
              <a href="#" class="credit-badge" data-name="Mirko D'Angelo">
                <span class="credit-name">Fulmine rosso_00</span>
              </a>
            </div>
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