<?php
session_start();
require 'config.php';

// Controlla se l'utente è loggato e se è admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: loginPage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_attivita = $_POST['nome_attivita'];
    $id_luogo = $_POST['id_luogo'];
    $id_categoria = $_POST['id_categoria'];
    $descrizione = $_POST['descrizione'];
    
    // Gestione upload immagine
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["immagine"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Controlli sull'immagine
    $check = getimagesize($_FILES["immagine"]["tmp_name"]);
    if($check === false) {
        die("Il file non è un'immagine.");
    }
    
    if ($_FILES["immagine"]["size"] > 5000000) {
        die("L'immagine è troppo grande (max 5MB).");
    }
    
    if(!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        die("Solo formati JPG, JPEG, PNG e GIF sono permessi.");
    }
    
    if (move_uploaded_file($_FILES["immagine"]["tmp_name"], $target_file)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO ATTIVITA (id_luogo, immagine_attivita, nome_attivita, id_categoria, descrizione) 
                                  VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$id_luogo, $target_file, $nome_attivita, $id_categoria, $descrizione]);
            
            $_SESSION['success_message'] = "Attività aggiunta con successo!";
            header('Location: admin.php');
        } catch (PDOException $e) {
            die("Errore durante l'inserimento: " . $e->getMessage());
        }
    } else {
        die("Si è verificato un errore durante l'upload dell'immagine.");
    }
}