<?php
 session_start();
?>

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
          <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            Login
        </a>
        </li>


        <li class="nav-item">
        <a class="nav-link" href="./profile.php" role="button" >
            Il tuo profilo 
        </a>
        </li>


        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Filtri
          </a>
          <ul class="dropdown-menu">
           
            <li><a class="dropdown-item" href="#">Nessun filtro disponibile </a></li>
            <li><hr class="dropdown-divider"></li>
            
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
                <h5 class=" text-center mb-3">Informazioni aggiuntive su:</h5>
                <h1 class="display-4 text-center mb-0"><?php echo htmlspecialchars( $_SESSION['username']); ?></h1>
                <h5 class=" mt-2 text-center">(<?php echo htmlspecialchars( $_SESSION['user_name']); ?>)</h5>
            </div>
          </div>
  </div>

  
  









<!--button per vedere le attività-->
<div class="w-75 mx-auto text-center mt-5 d-flex justify-content-center position-relative">  
    <a href="user_activities.php" class="button1 btn">
        <p>Visualizza le tue attività</p>
    </a>
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