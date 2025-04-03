<?php
    (include "./connessione.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dettagli-attività</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <h1>pagina dettagli</h1>
    <?php
        //inizzializzazione delle variabili
        $id_attivita = $_GET['id'];
        $nomeAttivita = "";
        $luogoAttivita = "";
        $ditoAttivita = "";
        $categoria_attivita = "";
          
        $query = $conn->query("SELECT * from attivita join luogo on luogo.id_parco = attivita.id_luogo  where attivita.id_attivita = '$id_attivita'");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            //assegnazione dei valori alle variabili
            $nomeAttivita = $row['nome_attivita'];
            $luogoAttivita = $row['nome_luogo'];
            $sitoAttivita = $row['link_sito'];
            $categoria_attivita = $row['categoria_attivita'];
            $immagine_attivita = $row['immagine_attivita'];
            $link_sito = $row['link_sito'];
            $descAttivita = $row['descrizione'];
          }
    ?>  
    
    <!doctype html>
      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Info</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      </head>
      <body>
      <!--navbar-->
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand">Nome_sito</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
              <a class="nav-link" href="<?php echo $sitoAttivita; ?>">Maggiori informazioni</a>
            </div>
          </div>
        </div>
      </nav>
        <h1 class="text-center text-danger"><?php echo $nomeAttivita; ?></h1>
        <div class="w-75 mx-auto my-auto">
          <!--grid-->
          <div class="container text-center">
            <div class="row">
              <div class="col-8"><img src="<?php echo $immagine_attivita; ?>" class="card-img-top"></div>
              <div class="col-4 text-left"><p><?php echo $descAttivita; ?></p></div>
            </div>
          </div><!--fine grid-->
          <!--div per recensioni-->
          <!--SELECT * from attivita join recensione on recensione.id_recensione = attivita.id_attivita-->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      </body>
    </html>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
