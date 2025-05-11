<?php
session_start();
require 'config.php';

// Verifica se l'utente è admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: loginPage.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_recensione'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM RECENSIONE WHERE id_recensione = ?");
        $stmt->execute([$_POST['id_recensione']]);
        
        $_SESSION['success_message'] = "Recensione eliminata con successo!";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Errore durante l'eliminazione: " . $e->getMessage();
    }
}

header('Location: admin.php');
exit();
?>
