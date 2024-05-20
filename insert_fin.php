<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs saisies dans le formulaire
    $newDate = $_POST["date"];
    $newNumeroAppel = $_POST["numero_appel"];
    $newNomPrenom = $_POST["nom_prenom"];
    $newCIN = $_POST["cin"];
   
    $newValeur = $_POST["valeur"];
    $newDeduction = $_POST["deduction"];
    $newMontantNette = $_POST["montant_nette"];
    $newCompetition = $_POST["competition"];
    
    $newSituation = $_POST["situation"];
    $newDateKhalass = $_POST["date_khalass"];
    $newCheque = $_POST["cheque"];
    $newBanque = $_POST["banque"];
    $newEtatEnvoiExpert = $_POST["etat_envoi_expert"];
    $newRDV = $_POST["rdv"];
    $newCompte = $_POST["compte"];
    $newAnneeComptable = $_POST["annee_comptable"];

   

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
    $sql = "INSERT INTO table_gagnants (date_gagnant, numero_appel, nom_prenom, cin, valeur, deduction, montant_nette, competition,  situation, date_khalass, cheque, banque, etat_envoi_expert, rdv, compte, annee_comptable) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Préparer la déclaration
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Lier les paramètres
        mysqli_stmt_bind_param($stmt, "ssssddssssssssss", $newDate, $newNumeroAppel, $newNomPrenom, $newCIN, $newValeur, $newDeduction, $newMontantNette, $newCompetition, $newSituation, $newDateKhalass, $newCheque, $newBanque, $newEtatEnvoiExpert, $newRDV, $newCompte, $newAnneeComptable);


        // Exécuter la déclaration
        if (mysqli_stmt_execute($stmt)) {
            echo "Nouvelle entrée ajoutée avec succès.";
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
