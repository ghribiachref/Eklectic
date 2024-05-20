<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "table_gagnants";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $editId = $_POST["editId"];
    $editDate = $_POST["editDate"];
    $editNumeroAppel = $_POST["editNumeroAppel"];
    $editNomPrenom = $_POST["editNomPrenom"];
    $editCIN = $_POST["editCIN"];
    $editWilaya = $_POST["editWilaya"];
    $editTypePrix = $_POST["editTypePrix"];
    $editValeur = $_POST["editValeur"];
    $editDeduction = $_POST["editDeduction"];
    $editMontantNette = $_POST["editMontantNette"];
    $editCompetition = $_POST["editCompetition"];
    $editNiveauCompetition = $_POST["editNiveauCompetition"];
    $editSituation = $_POST["editSituation"];
    $editDateKhalass = $_POST["editDateKhalass"];
    $editCheque = $_POST["editCheque"];
    $editBanque = $_POST["editBanque"];
    $editEtatEnvoiExpert = $_POST["editEtatEnvoiExpert"];
    $editRDV = $_POST["editRDV"];
    $editCompte = $_POST["editCompte"];
    $editAnneeComptable = $_POST["editAnneeComptable"];

    // Préparer la requête de mise à jour
    $sql = "UPDATE table_gagnants SET
            date_gagnant = '$editDate',
            numero_appel = '$editNumeroAppel',
            nom_prenom = '$editNomPrenom',
            cin = '$editCIN',
            wilaya = '$editWilaya',
            type_prix = '$editTypePrix',
            valeur = '$editValeur',
            deduction = '$editDeduction',
            montant_nette = '$editMontantNette',
            competition = '$editCompetition',
            niveau_competition = '$editNiveauCompetition',
            situation = '$editSituation',
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
        header("Location: admin_dashboard.php"); // Redirigez vers la page principale après la mise à jour
        exit();
    } else {
        echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
    }
}
?>
