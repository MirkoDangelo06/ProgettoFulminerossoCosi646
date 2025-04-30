<?php
  (include "./connessione.php");//inclusione del file di connessione
?>
<!doctype html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Risultati della ricerca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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
    </style>
  </head>
  <body style="background-color:#f3f5f6;">
<div class="text-center">
<!--navbar estesa per la modalità ricerca-->
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
        </ul>
        </ul>


        <!-- Dropdown Filtri -->
        <div class="ms-auto me-3">
          <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="filtriDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-sliders"></i> Ordina
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
      //controlli per stabilire il tipo di query da effettuare
        $ricercaSelezionata = $_POST['tipoRicerca'];
        if($ricercaSelezionata == "ricerca"){ //se la ricerca è avvenuta con la barra di ricerca
            $valoreDaCercare = $_POST['valoreDaCercare']; //recupero la stringa da cercare
            $query =  $conn->query("SELECT * FROM attivita 
            JOIN luogo ON attivita.id_luogo = luogo.id_parco 
            WHERE attivita.nome_attivita LIKE '%$valoreDaCercare%'");
          }else if($ricercaSelezionata == "filtroRegioni"){//se l'utente ha deciso di filtrare per regione
            $regioneFiltro = isset($_POST['regioneSelect']) ? htmlspecialchars($_POST['regioneSelect']) : '';
            $query = $conn->query("SELECT  * FROM attivita join luogo on luogo.id_parco = attivita.id_luogo join locazione on locazione.id_locazione = luogo.id_locazione where locazione.regione = '$regioneFiltro'");
          }else if($ricercaSelezionata == "filtroLuoghi"){//se l'utente ha deciso di filtrare per luoghi
            $luogoID = isset($_POST['luoghiSelect']) ? htmlspecialchars($_POST['luoghiSelect']) : '';
            $query = $conn->query("SELECT * FROM attivita join luogo on luogo.id_parco = attivita.id_luogo WHERE luogo.id_parco = '$luogoID'");
          }else if($ricercaSelezionata == "filtroTipo"){//se l'utente ha deciso di filtrare per tipoLuogo
            $tipoID = isset($_POST['tipoSelect']) ? htmlspecialchars($_POST['tipoSelect']) : '';
            $query = $conn->query("SELECT * FROM attivita join luogo on luogo.id_parco = attivita.id_luogo join tipo_luogo on tipo_luogo.id_tipo = luogo.id_tipo where tipo_luogo.id_tipo = '$tipoID'");
          }
          $results = $query->fetchAll(PDO::FETCH_ASSOC);
          if(count($results) == 0){ //SE NON CI SONO CORRISPONDENZE
            echo '
            <div class="container w-50 d-flex flex-column justify-content-center">
                <div class="text-center p-5 bg-white rounded-3 shadow-sm">
                    <!-- Icona a tema (scegli una delle opzioni) -->
                    <div class="fs-1 mb-3">🔎</div>
                    <h1 class=" mb-4 text-danger">Nessuna Corrispondenza!</h1>         
                    <p class="mt-4 text-muted small">
                        PS: Prova a cercare nel menu oppure torna alla Home!
                    </p>
                </div>
            </div>';
          }
           //stampa della griglia con i risultati
           echo '<div class="row">';
           $counter = 0;
           foreach ($results as $row) {
               if ($counter % 3 == 0 && $counter != 0) {
                   echo '</div><div class="row">';
               }
               echo '<div class="col-md-4 mb-4">';
               echo '  <div class="card" style="width: 18rem;">';
               echo '    <img src="' . htmlspecialchars($row['immagine_attivita']) . '" class="card-img-top object-fit-cover img-fluid">';
               echo '    <div class="card-body">';
               echo '      <h5 class="card-title orbitron-bold">' . htmlspecialchars($row['nome_attivita']) . '</h5>';
               echo '      <p class="card-content inter-paragrafi">' . htmlspecialchars($row['nome_luogo']) . '</p>';
               echo '      <a href="details.php?id=' . $row['id_attivita'] . '" class="btn button2">Maggiori Informazioni</a>';
               echo '    </div>';
               echo '  </div>';
               echo '</div>';
   
               $counter++;
            }  
        // Chiudi l'ultima riga e il container
        echo '</div>';
        ?>
    </div><!-- chiusura container -->
  <form>     
</div><!-- chiusura del div principale -->

<!-- Footer Section with less elements -->
<footer class="text-light py-3 mt-5 text-center" style="background-color: #2D3748;">
  <div class="w-50 mx-auto my-auto">
    <h5 class="text-uppercase mb-4 border-bottom pb-2">Link Utili</h5>
    <ul class="list-unstyled "> 
      <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Crediti</a></li>
      <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Privacy e Cookie</a></li>
      <li class="mb-2"><a href="#" class="text-light text-decoration-none hover-underline">Termini di Servizio</a></li>
      <li><a href="#" class="text-light text-decoration-none hover-underline">Contattaci</a></li>
    </ul>
  </div>
</footer>


<!--body of the toast messaage, it informs the user that he is in search mode-->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="searchToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="./images/stoCoseDafarelogo.png" class="rounded me-2" height="70">
      <strong class="me-auto">Ti trovi in modalità ricerca</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Per uscire dalla modalità ricerca è sufficente fare ritorno alla pagina Home
    </div>
  </div>
</div>

<script>
  //script per mostrare il messaggio toast
  window.addEventListener('DOMContentLoaded', (event) => {
    const toastEl = document.getElementById('searchToast');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
  });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
  </body>
</html>