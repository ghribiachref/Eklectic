<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les données du formulaire sont reçues
    if (isset($_POST["editId"])) {
        $editId = $_POST["editId"];
        $editDate = $_POST["editDate"];
        $editNomPrenom = $_POST["editNomPrenom"];
        $editValeur = $_POST["editValeur"];
        $editDeduction = $_POST["editDeduction"];
        $editMontantNette = $_POST["editMontantNette"];
        $editCompetition = $_POST["editCompetition"];
        
        $editSituation = $_POST["editSituation"];
        $editDateKhalass = $_POST["editDateKhalass"];
        $editCheque = $_POST["editCheque"];
        $editBanque = $_POST["editBanque"];
        $editEtatEnvoiExpert = $_POST["editEtatEnvoiExpert"];
        $editRDV = $_POST["editRDV"];
        $editCompte = $_POST["editCompte"];
        $editAnneeComptable = $_POST["editAnneeComptable"];

        // Connexion à la base de données
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "table_gagnants";

        $conn = mysqli_connect($host, $username, $password, $dbname);

        if (!$conn) {
            die("La connexion à la base de données a échoué: " . mysqli_connect_error());
        }

        // Préparez la requête de mise à jour
        $sql = "UPDATE table_gagnants SET
                date_gagnant = '$editDate',
                nom_prenom = '$editNomPrenom',
                valeur = '$editValeur',
                deduction = '$editDeduction',
                montant_nette = '$editMontantNette',
                competition = '$editCompetition',
               
                situation = '$editSituation' ,
                date_khalass = '$editDateKhalass',
                cheque = '$editCheque',
                banque = '$editBanque',
                etat_envoi_expert = '$editEtatEnvoiExpert',
                rdv = '$editRDV',
                compte = '$editCompte',
                annee_comptable = '$editAnneeComptable'
                WHERE id = $editId";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location:financier_dashboard.php"); // Redirigez vers la page principale après la mise à jour
            exit();
        } else {
            echo "Erreur lors de la mise à jour des données: " . mysqli_error($conn);
        }
    } else {
        echo "Données de formulaire manquantes.";
    }
} else {
    echo "Cette page ne peut pas être accédée directement.";
}
?>
