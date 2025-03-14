<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        main {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .link {
            margin-bottom: 20px;
            text-align: right;
        }

        .link a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4b0082;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .link a:hover {
            background-color: #9370db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4b0082;
            color: white;
            font-weight: bold;
            width: 25%;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f5f0ff;
        }

        .image {
            text-align: center;
        }

        .image img {
            width: 24px;
            height: 24px;
            transition: transform 0.2s;
        }

        .image img:hover {
            transform: scale(1.2);
        }

        .profile-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <main>
        <div class="link">
            <a href="adduser.php">Ajouter un utilisateur</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Login</th>
                    <th>Photo</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
            <?php
           
            $host = "localhost";
            $username ="root";
            $passwd ="";
            $dbname="crud";
            $conn = mysqli_connect($host, $username,$passwd,$dbname);
            if(!$conn){
                die("Connexion echoué");
            }
            
                $sql = "SELECT * FROM utilisateur";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) { 
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $row['id'] ?></td>  
                <td><?= $row['prenom'] ?></td>  
                <td><?= $row['nom'] ?></td>
                <td><?= $row['login'] ?></td>
                <td><img src="<?= $row['photo'] ?>" alt="Photo de profil" class="profile-photo"></td>
                <td class="image">
                    <a href="modifier_utilisateur.php?id=<?= $row['id'] ?>"> 
                    <img src="write.png" alt="Modifier">
                    </a>
                </td>
                <td class="image">
                    <a href="supprimer.php?id=<?= $row['id'] ?>"> 
                        <img src="remove.png" alt="Supprimer">
                    </a>
                </td>
            </tr> 
            <?php
                }
            } else {
                echo "Aucun utilisateur trouvé";
            }
            mysqli_close($conn);
            ?>
            </tbody>
        </table>
    </main>
</body>
</html>
