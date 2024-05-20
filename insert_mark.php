<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs saisies dans le formulaire
    $newDate = $_POST["date"];
    $newNumeroAppel = $_POST["numero_appel"];
    $newNomPrenom = $_POST["nom_prenom"];
    $newCIN = $_POST["cin"];
    $newWilaya = $_POST["wilaya"];
    $newTypePrix = $_POST["type_prix"];
    $newMontantNette = $_POST["montant_nette"];
    $newCompetition = $_POST["competition"];
    $newNiveauCompetition = $_POST["niveau_competition"];
    $newSituation = $_POST["situation"];
   

   


    // Connexion à la base de données
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "table_gagnants";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    // Vérifier si la connexion a réussi
    if (!$conn) {
        die("La connexion à la base de données a échoué: " . mysqli_connect_error());
    }

    // Préparer la requête SQL pour insérer les nouvelles données
    $sql = "INSERT INTO table_gagnants (date_gagnant, numero_appel, nom_prenom, cin, wilaya, type_prix,  montant_nette, competition, niveau_competition, situation) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Préparer la déclaration
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Lier les paramètres
        mysqli_stmt_bind_param($stmt, "ssssddssss", $newDate, $newNumeroAppel, $newNomPrenom, $newCIN, $newWilaya, $newTypePrix,  $newMontantNette, $newCompetition, $newNiveauCompetition, $newSituation);

        // Exécuter la déclaration
        if (mysqli_stmt_execute($stmt)) {
            // Rediriger vers la page marketing_dashboard après l'ajout réussi
            header("Location: marketing_dashboard.php");
            exit(); // Assurez-vous de mettre exit() pour arrêter l'exécution du script ici
        } else {
            echo "Erreur lors de l'ajout de l'entrée: " . mysqli_stmt_error($stmt);
        }
        // Fermer la déclaration
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur lors de la préparation de la requête: " . mysqli_error($conn);
    }

    // Fermer la connexion
    mysqli_close($conn);
}
?>

