<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "crud");

if (!$conn) die("Connexion échouée : " . mysqli_connect_error());

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérifier si l'email et le mot de passe sont corrects
    $sql = "SELECT * FROM admin WHERE email = '$email' AND mdp = '$mot_de_passe'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin'] = $email; // On stocke email de l'admin en session
        header("Location: show.php"); 
        exit();
    } else {
        $message = "Identifiants incorrects.";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Administration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        main {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4b0082;
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        label {
            color: #4b0082;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #9370db;
            box-shadow: 0 0 5px rgba(147, 112, 219, 0.2);
        }

        button[type="submit"] {
            background-color: #4b0082;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #9370db;
        }

        .message {
            text-align: center;
            color: #ff0000;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
            background-color: #ffe6e6;
        }
    </style>
</head>
<body>
    <main>
        <h1>Connexion Administration</h1>
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </main>
</body>
</html>
