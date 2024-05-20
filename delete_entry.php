<?php
// Connexion à la base de données MySQL 
$host = "localhost";
$username = "root";
$password = "";
$dbname = "table_gagnants";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

// Vérifier si l'ID est passé en tant que paramètre GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour supprimer l'enregistrement avec l'ID correspondant
    $sql = "DELETE FROM table_gagnants WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Enregistrement supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'enregistrement: " . mysqli_error($conn);
    }
} else {
    echo "ID non spécifié pour la suppression.";
}

mysqli_close($conn);
?>
