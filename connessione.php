<?php
    $host = "localhost"; 
    $user = "root";
    $db = "AttivitaDB";
    $pass = "";

    // Connessione al database usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
?>