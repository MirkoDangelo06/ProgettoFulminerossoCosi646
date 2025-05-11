<?php
session_start();
require 'config.php';

// Controlla se l'utente è loggato e se è admin
if (!isset($_SESSION['user_id'])) {
    header('Location: loginPage.php');
    exit();
}

if (!$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

// Qui puoi mettere il form per aggiungere attività
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Amministratore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

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

    <div class="container mt-5">
        <div>
            <h1 class="mb-4">Pannello Amministratore</h1>
        <div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h2>Aggiungi Nuova Attività</h2>
            </div>
            <div class="card-body">
                <form action="add_activity.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nome Attività</label>
                        <input type="text" name="nome_attivita" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Luogo</label>
                        <select name="id_luogo" class="form-select" required>
                            <?php
                            $query = $pdo->query("SELECT id_parco, nome_luogo FROM LUOGO");
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$row['id_parco'].'">'.$row['nome_luogo'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Immagine</label>
                        <input type="file" name="immagine" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <select name="id_categoria" class="form-select" required>
                            <?php
                            $query = $pdo->query("SELECT id_categoria, categoria_attivita FROM CATEGORIA");
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$row['id_categoria'].'">'.$row['categoria_attivita'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descrizione</label>
                        <textarea name="descrizione" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Aggiungi Attività</button>
                </form>
            </div>
        </div>
    </div>



    <div class="card mt-4">
    <div class="card-header">
        <h2>Gestione Recensioni</h2>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Attività</th>
                    <th>Utente</th>
                    <th>Voto</th>
                    <th>Recensione</th>
                    <th>Data</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $pdo->query("
                    SELECT r.id_recensione, r.voto, r.testoRecensione, r.dataRecensione,
                           a.nome_attivita, p.username
                    FROM RECENSIONE r
                    JOIN ATTIVITA a ON r.id_attivita = a.id_attivita
                    JOIN PERSONA p ON r.id_persona = p.id_persona
                    ORDER BY r.dataRecensione DESC
                ");
                
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>'.htmlspecialchars($row['nome_attivita']).'</td>';
                    echo '<td>'.htmlspecialchars($row['username']).'</td>';
                    echo '<td>'.str_repeat('★', $row['voto']).str_repeat('☆', 5 - $row['voto']).'</td>';
                    echo '<td>'.htmlspecialchars($row['testoRecensione']).'</td>';
                    echo '<td>'.htmlspecialchars($row['dataRecensione']).'</td>';
                    echo '<td>
                            <form action="delete_review.php" method="post" style="display:inline;">
                                <input type="hidden" name="id_recensione" value="'.$row['id_recensione'].'">
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm(\'Sei sicuro di voler eliminare questa recensione?\')">
                                    <i class="bi bi-trash"></i> Elimina
                                </button>
                            </form>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>