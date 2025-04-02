<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM PERSONA WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Imposta le variabili di sessione SOLO se il login ha successo
            $_SESSION['user_id'] = $user['id_persona'];
            $_SESSION['user_name'] = $user['nome'] . ' ' . $user['cognome'];
            $_SESSION['username'] = $user['username'];
            
            header('Location: index.php');
            exit();
        } else {
            $error = 'Username o password non validi';
        }
    } catch (PDOException $e) {
        $error = 'Errore durante il login';
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2 class="text-center mb-4">Accedi</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Accedi</button>
            </form>
            
            <div class="mt-3 text-center">
                <a href="register.php" class="text-dark">Crea un account</a>
            </div>
        </div>
    </div>
</body>
</html>