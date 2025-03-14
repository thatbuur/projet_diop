<?php
    $id = $_GET['id'];
    $host = "localhost";
    $username ="root";
    $passwd ="";
    $dbname="crud";
    $conn = mysqli_connect($host, $username,$passwd,$dbname);
    if(!$conn){
        die("Connexion echoué");
     }
            
    $sql = "DELETE  FROM utilisateur where id= $id";
    if(mysqli_query($conn,$sql)){
        header("location:show.php");
    }else{
        
    }
?>