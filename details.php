<?php
    include "./connessione.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dettagli-attività</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--leaflet!-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  </head>
  <body>
    <?php
        $id_attivita = $_GET['id'];
        $query = $conn->query("SELECT * FROM attivita JOIN luogo ON luogo.id_parco = attivita.id_luogo JOIN locazione ON locazione.id_locazione = luogo.id_parco where attivita.id_attivita = '$id_attivita'");
        if ($query && $row = $query->fetch(PDO::FETCH_ASSOC)) {
            // Coordinate geografiche
            $latitudine = $row['latitudine'];  
            $longitudine = $row['longitudine']; 
            // Generalità dell'attività
            $nomeAttivita = $row['nome_attivita'];
        } else {
            // Gestisci l'errore (es. nessun risultato trovato)
            echo "Nessuna Recensione trovata per questa attività";
        }
    ?>


    <div class="bg-dark text-white py-4 mb-4 shadow">
          <div class="container">
            <div class="row">
                <h5 class=" text-center mb-3">Informazioni aggiuntive su:</h5>
                <h1 class="display-4 text-center mb-0"><?php echo htmlspecialchars($nomeAttivita); ?></h1>
            </div>
          </div>
    </div>
    <!-- Mostra la mappa -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
          <div class="card shadow">
            <div class="card-body p-0">
              <div id="map" style="height: 400px;"></div>
            </div>
            <div class="card-footer bg-white">
              <small class="text-muted">Posizione dell'attività</small>
            </div>
          </div>
        </div>
      </div>

    
      <div class="mt-4 border-top pt-3 w-75 mx-auto my-auto">
        <?php //stampa delle recensioni
        $query2 = $conn->query("SELECT * FROM recensione 
            JOIN attivita ON attivita.id_attivita = recensione.id_attivita 
            JOIN persona ON persona.id_persona = recensione.id_persona 
            WHERE attivita.id_attivita = '$id_attivita'");

        if ($query2 && $query2->rowCount() > 0) {
            while ($row = $query2->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="mb-3 p-3 bg-light rounded">';
                echo '<div class="d-flex justify-content-between">';
                echo '<strong>' . htmlspecialchars($row['username']) . '</strong>';
                echo '<small class="text-muted">' . htmlspecialchars($row['dataRecensione']) . '</small>';
                echo '</div>';
                echo '<p class="mb-0 mt-2">' . nl2br(htmlspecialchars($row['testoRecensione'])) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-muted font-italic">Nessuna recensione disponibile</p>';
        }
        ?>
      </div>
      <div class="text-center">
        <a href="./index.php" class="btn btn-success mt-3">Torna Indietro</a>
      </div>
    <script>
      // Coordinate ricavate con il fetch assoc
      var latitudine = <?php echo $latitudine; ?>;
      var longitudine = <?php echo $longitudine; ?>;


      // Crea la mappa e imposta il punto di vista sulle coordinate recuperate
      var map = L.map('map').setView([latitudine, longitudine], 13);


      // Aggiungi il layer di base (OpenStreetMap)
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);


      // marker sulla mappa con le coordinate
      L.marker([latitudine, longitudine]).addTo(map)
          .openPopup();
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>