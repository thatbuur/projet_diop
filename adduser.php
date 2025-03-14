<?php
$host = "localhost";
$username = "root";
$passwd = "";
$dbname = "crud";
$conn = mysqli_connect($host, $username, $passwd, $dbname);

if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    $login = $_POST["login"];

    $photo = "picture/image.png"; // Valeur par défaut

    if (!empty($_FILES["photo"]["name"])) {
        $target_dir = "picture/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = $target_file;
        }
    }

    $sql = "INSERT INTO utilisateur (id, nom, prenom, login, mdp, photo) 
            VALUES (UUID(), '$nom', '$prenom', '$login', '$mdp', '$photo')";

    if ($conn->query($sql) === TRUE) {
        header("location: show.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
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

        input[type="text"], input[type="password"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #9370db;
            box-shadow: 0 0 5px rgba(147, 112, 219, 0.2);
        }

        input[type="text"]::placeholder, input[type="password"]::placeholder {
            color: #999;
        }

        input[type="submit"] {
            background-color: #4b0082;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #9370db;
        }
    </style>
</head>
<body>
    <main>
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Ajouter un utilisateur</h1>
            <input type="text" name="prenom" placeholder="Prénom" required>
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="text" name="login" placeholder="Login" required>
            <input type="password" name="mdp" placeholder="Mot de passe" required>
            Photo: <input type="file" id="photo" name="photo" accept="image/*">
            <input type="submit" value="Ajouter" name="send">
        </form>
    </main>
</body>
</html>