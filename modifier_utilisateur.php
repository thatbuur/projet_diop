<?php
$id = $_GET['id'];

if (isset($_POST['send'])) {
    if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['login']) && isset($_POST['mdp'])) {
        $host = "localhost";
        $username = "root";
        $passwd = "";
        $dbname = "crud";
        $conn = mysqli_connect($host, $username, $passwd, $dbname);

        if (!$conn) {
            die("Connexion échouée : " . mysqli_connect_error());
        }

        extract($_POST);

        
        $photo = $_POST['photo_actuelle']; // Conserver la photo actuelle par défaut
        if (!empty($_FILES["photo"]["name"])) {
            $target_dir = "picture/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        }

        // Hachage du mot de passe si modifié
        $mdp_hash = $_POST['mdp_actuel']; // Conserver le mot de passe actuel par défaut
        if (!empty($mdp)) {
            $mdp_hash = password_hash($mdp, PASSWORD_BCRYPT);
        }

        
        $sql = "UPDATE utilisateur 
                SET prenom = '$prenom', 
                    nom = '$nom', 
                    login = '$login', 
                    mdp = '$mdp_hash', 
                    photo = '$photo' 
                WHERE id = '$id'";

        if (mysqli_query($conn, $sql)) {
            header("location: show.php");
            exit();
        } else {
            echo "Erreur : " . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur</title>
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

        input[type="text"], input[type="password"], input[type="file"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus, input[type="file"]:focus {
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
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #9370db;
        }
    </style>
</head>
<body>
<?php
$host = "localhost";
$username = "root";
$passwd = "";
$dbname = "crud";
$conn = mysqli_connect($host, $username, $passwd, $dbname);

if (!$conn) {
    die("Connexion échouée");
}

$sql = "SELECT * FROM utilisateur WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<main>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Modifier un utilisateur</h1>
        <input type="text" name="prenom" value="<?= $row['prenom'] ?>" placeholder="Prénom" required>
        <input type="text" name="nom" value="<?= $row['nom'] ?>" placeholder="Nom" required>
        <input type="text" name="login" value="<?= $row['login'] ?>" placeholder="Login" required>
        <input type="password" name="mdp" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)">
        <input type="hidden" name="mdp_actuel" value="<?= $row['mdp'] ?>">
        <input type="file" name="photo" accept="image/*">
        <input type="hidden" name="photo_actuelle" value="<?= $row['photo'] ?>">
        <input type="submit" name="send" value="Modifier">
    </form>
</main>

<?php
mysqli_close($conn);
?>
</body>
</html>
