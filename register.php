<?php
session_start();
require 'config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validazioni di base
    if (empty($nome)) $errors[] = 'Il nome è obbligatorio';
    if (empty($cognome)) $errors[] = 'Il cognome è obbligatorio';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email non valida';
    if (empty($username)) $errors[] = 'Username obbligatorio';
    if (strlen($password) < 8) $errors[] = 'La password deve avere almeno 8 caratteri';
    if ($password !== $confirm_password) $errors[] = 'Le password non coincidono';
    
    if (empty($errors)) {
        try {
            // Verifica se username o email esistono già
            $stmt = $pdo->prepare("SELECT id_persona FROM PERSONA WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->rowCount() > 0) {
                $errors[] = 'Username o email già in uso';
            } else {
                //crittografia 
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $pdo->prepare("INSERT INTO PERSONA (nome, cognome, email, username, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nome, $cognome, $email, $username, $hashed_password]);
                
                $_SESSION['registration_success'] = true;
                header('Location: loginPage.php');
                exit();
            }
        } catch (PDOException $e) {
            $errors[] = 'Errore durante la registrazione';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body style="background-color:#f3f5f6;">
    <div class="container">
        <div class="register-box">
            <h2 class="text-center mb-4">Registrati</h2>
            
            <!--da rivedere -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?= $error ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cognome</label>
                        <input type="text" name="cognome" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-muted">Minimo 8 caratteri</small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Conferma Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn w-100" style="background-color: #0d5c26; color: white;">Registrati</button>
            </form>
            
            <div class="mt-3 text-center">
                <a href="loginPage.php" style="color: #0d5c26;">Hai già un account? Accedi</a>
            </div>
            
            <div class="text-center">
             <a href="./index.php" class="btn mt-3" style="background-color: #0d5c26; color: white;">Continua senza account</a>
            </div>
        </div>
    </div>
</body>
</html>