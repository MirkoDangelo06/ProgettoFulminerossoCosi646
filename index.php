<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carosello con griglia di cards</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">
<br>
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <!--slide 1-->
    <div class="carousel-item active">
      <div class="container">
        <div class="row">
          <!-- Card 1 -->
          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
              <div class="card-body">
                <h5 class="card-title">Card 1</h5>
                <p class="card-text">Questa è la prima card.</p>
              </div>
            </div>
          </div>
          <!-- Card 2 -->
          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
              <div class="card-body">
                <h5 class="card-title">Card 2</h5>
                <p class="card-text">Questa è la seconda card.</p>
              </div>
            </div>
          </div>
          <!-- Card 3 -->
          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
              <div class="card-body">
                <h5 class="card-title">Card 3</h5>
                <p class="card-text">Questa è la terza card.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--slide 2-->
    <div class="carousel-item">
      <div class="container">
        <div class="row">
          <!-- Card 4 -->
          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
              <div class="card-body">
                <h5 class="card-title">Card 4</h5>
                <p class="card-text">Questa è la quarta card.</p>
              </div>
            </div>
          </div>
          <!-- Card 5 -->
          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
              <div class="card-body">
                <h5 class="card-title">Card 5</h5>
                <p class="card-text">Questa è la quinta card.</p>
              </div>
            </div>
          </div>
          <!-- Card 6 -->
          <div class="col-md-4">
            <div class="card" style="width: 18rem;">
              <img src="https://via.placeholder.com/150" class="card-img-top" alt="Card image">
              <div class="card-body">
                <h5 class="card-title">Card 6</h5>
                <p class="card-text">Questa è la sesta card.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Controlli del carosello -->
  <!-- indietro -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Precedente</span>
  </button>
    <!-- avanti -->
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Successivo</span>
  </button>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<!--Navbar-->