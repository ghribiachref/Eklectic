<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "table_gagnants";

// Connexion à la base de données
$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $editId = $_POST['editId'];
    $editDate = $_POST['editDate'];
    $editNomPrenom = $_POST['editNomPrenom'];
    $editWilaya = $_POST['editWilaya'];
    $editTypePrix = $_POST['editTypePrix'];
    $editMontantNette = $_POST['editMontantNette'];
    $editCompetition = $_POST['editCompetition'];
    $editNiveauCompetition = $_POST['editNiveauCompetition'];
    $editSituation = $_POST['editSituation'];

    // Préparer et exécuter la requête de mise à jour
    $sql = "UPDATE table_gagnants SET 
            date_gagnant = '$editDate', 
            nom_prenom = '$editNomPrenom', 
            wilaya = '$editWilaya', 
            type_prix = '$editTypePrix', 
            montant_nette = '$editMontantNette', 
            competition = '$editCompetition', 
            niveau_competition = '$editNiveauCompetition', 
            situation = '$editSituation' 
            WHERE id = $editId";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: marketing_dashboard.php"); // Redirigez vers la page principale après la mise à jour
        exit();
    } else {
        echo "Erreur lors de la mise à jour de l'enregistrement: " . mysqli_error($conn);
    }
}


?>
