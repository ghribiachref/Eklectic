<?php
// admin_dashboard.php

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Rediriger vers la page de connexion ou autre page appropriée
    header('Location: cnxlogin.php');
    exit();
}

// Déconnexion
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    // Effacer la session
    session_unset();
    session_destroy();
    header('Location: cnxlogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        /* Classe pour les lignes avec plus de 6 mois */
.red-row td.date-cell {
    background-color: red;
    color: white; /* Changer la couleur du texte si nécessaire */
}

/* Classe pour les lignes avec  situation "payé" ou "payée" */
.green-row td.date-cell {
    background-color: green;
    color: white; /* Changer la couleur du texte si nécessaire */
}

/* Classe pour les lignes avec moins de 6 mois */
.yellow-row td.date-cell {
    background-color: yellow;
    /* Choisir une couleur de texte appropriée */
}

        .table-container {
    overflow-x: auto; /* Ajoute un défilement horizontal si le contenu dépasse */
    max-width: 100%; /* Empêche le débordement du conteneur */
    margin-bottom: 20px;
}



        /* CSS pour les boutons d'action */
.action-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 20px;
    color: #444;
    transition: color 0.3s, transform 0.3s;
}

.action-btn.edit-btn::before {
    content: "\270E"; /* Pencil icon */
}

.action-btn.delete-btn::before {
    content: "\2716"; /* Cross icon */
}

.action-btn.add-btn::before {
    content: "+"; /* Plus icon */
}

.action-btn:hover {
    color: #1064beb7; /* Change la couleur au survol */
    transform: scale(1.2); /* Agrandit légèrement le bouton au survol */
}

        /* Votre CSS pour le tableau ici */
        .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #1064beb7;
    padding: 10px 20px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    position: relative;
}

.logo-container img {
    width: auto;
    height: 50px;
    max-width: 100%;
}

.nav-links {
    display: flex;
    align-items: center;
}

.nav-links a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-size: 18px;
}

.nav-links a:hover {
    text-decoration: underline;
}

/* Aligner les liens à droite */
.nav-links {
    margin-left: auto;
}


        
        .logout-button {
    position: absolute;
    top: 10px;
    right: 10px;
}

.logout-button a {
    text-decoration: none;
    background-color: #FF0000; /* Couleur de fond du bouton */
    color: #FFFFFF; /* Couleur du texte */
    padding: 8px 12px;
    border-radius: 4px;
}

.logout-button a:hover {
    background-color: #CC0000; /* Couleur de fond au survol */
}
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://t3.ftcdn.net/jpg/03/55/60/70/360_F_355607062_zYMS8jaz4SfoykpWz5oViRVKL32IabTP.jpg');
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
           
        }

        table {
            border-collapse: collapse;
            width: 95%; /* Ajuster la largeur du tableau selon vos besoins */
            margin: 0 auto; /* Pour centrer le tableau horizontalement */
            margin-bottom: 30px;
            background-color: #f9f9f9; /* Couleur de fond */
            border: 2px solid #dddddd; /* Bordure du tableau */ 
        }

        th, td {
            border: 1px solid #dddddd; /* Bordure des cellules */
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            justify-content: space-between;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #444;
        }

        .action-btn.edit-btn::before {
            content: "\270E"; /* Pencil icon */
        }

        .action-btn.delete-btn::before {
            content: "\2716"; /* Cross icon */
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 0 0 30%; /* 30% de la largeur */
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #444;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #d8d8d8e0;
            border-radius: 3px;
        }

        .form-group button {
            background-color: #1064beb7;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            padding: 8px 15px;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }
        .logo-container {
            position: absolute;
            top: 10px;
            left: 10px;
          
        }
        .logo-container img {
            width: 200px;
            height: 50px;
        }
/* CSS pour le formulaire de modification */
.edit-form {
    background-color: #f9f9f9;
    padding: 20px;
    border: 2px solid #dddddd;
    width: 80%; /* Adjust the width of the form as needed */
    max-width: 500px; /* Limit the maximum width of the form */
    margin: 0 auto; /* Center the form horizontally */
}

.edit-form h2 {
    margin-bottom: 15px;
}

.edit-form .form-group {
    margin-bottom: 15px;
}

.edit-form .form-group label {
    color: #444;
    font-weight: bold;
    display: block;
}

.edit-form .form-group input[type="text"],
.edit-form .form-group input[type="number"],
.edit-form .form-group input[type="date"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #d8d8d8e0;
    border-radius: 3px;
    margin-top: 5px;
}

.edit-form .form-group button {
    background-color: #1064beb7;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    padding: 8px 15px;
    margin-top: 10px;
}

.edit-form .form-group button:hover {
    background-color: #0056b3;
}


    </style>
    <script>
        // Votre code JavaScript ici

        let id = 1; // Variable pour générer des identifiants uniques
        function addRow() {
  // Récupérer les valeurs saisies dans le formulaire d'ajout
  const date = document.getElementById('date').value;
  const numeroAppel = document.getElementById('numero_appel').value;
  const nomPrenom = document.getElementById('nom_prenom').value;
  const cin = document.getElementById('cin').value;
  const wilaya = document.getElementById('wilaya').value;
  const typePrix = document.getElementById('type_prix').value;
  const valeur = document.getElementById('valeur').value;
  const deduction = document.getElementById('deduction').value;
  const montantNette = document.getElementById('montant_nette').value;
  const competition = document.getElementById('competition').value;
  const niveauCompetition = document.getElementById('niveau_competition').value;
  const situation = document.getElementById('situation').value;
  const dateKhalass = document.getElementById('date_khalass').value;
  const cheque = document.getElementById('cheque').value;
  const banque = document.getElementById('banque').value;
  const etatEnvoiExpert = document.getElementById('etat_envoi_expert').value;
  const rdv = document.getElementById('rdv').value;
  const compte = document.getElementById('compte').value;
  const anneeComptable = document.getElementById('annee_comptable').value;

  // Créer une nouvelle ligne pour le tableau
  const newRow = document.createElement('tr');
   // Générer un identifiant unique pour la nouvelle ligne
   newRow.setAttribute('data-id', id);
            

  // Remplir la nouvelle ligne avec les données saisies
  newRow.innerHTML = `
    <td class="date-cell ${rowClass}">${date}</td>
    <td>${numeroAppel}</td>
    <td>${nomPrenom}</td>
    <td>${cin}</td>
    <td>${wilaya}</td>
    <td>${typePrix}</td>
    <td>${valeur}</td>
    <td>${deduction}</td>
    <td>${montantNette}</td>
    <td>${competition}</td>
    <td>${niveauCompetition}</td>
    <td>${situation}</td>
    <td>${dateKhalass}</td>
    <td>${cheque}</td>
    <td>${banque}</td>
    <td>${etatEnvoiExpert}</td>
    <td>${rdv}</td>
    <td>${compte}</td>
    <td>${anneeComptable}</td>
    <td class="actions">
      <button class="action-btn edit-btn" onclick="editRow(${id})">Modifier</button>
      <button class="action-btn delete-btn" onclick="deleteRow(${id})">Supprimer</button>
      <button class="action-btn add-btn" onclick="showAddForm()">Ajouter</button>';
    </td>
  `;

  // Ajouter la nouvelle ligne au tableau
  const table = document.querySelector('table');
  table.appendChild(newRow);

  
}
// Ajouter un gestionnaire d'événements pour le formulaire d'ajout
document.getElementById('addForm').addEventListener('submit', function (event) {
  event.preventDefault(); // Empêcher le formulaire d'être soumis
  addRow(); // Appeler la fonction pour ajouter la nouvelle ligne
  this.reset(); // Réinitialiser le formulaire après l'ajout
  id++;
});
function showAddForm() {
    document.getElementById('addForm').style.display = 'block';
}
function closeAddForm() {
    document.getElementById('addForm').style.display = 'none';
}


        function editRow(id) {
            // Récupérer les données de la ligne sélectionnée depuis le tableau affiché
            const row = document.querySelector(`tr[data-id="${id}"]`);
            const cells = row.cells;
            // Remplir les champs du formulaire de modification avec les données récupérées
            document.getElementById('editId').value = id;
            document.getElementById('editDate').value = cells[0].textContent;
            document.getElementById('editNumeroAppel').value = cells[1].textContent;
            document.getElementById('editNomPrenom').value = cells[2].textContent;
            document.getElementById('editCIN').value = cells[3].textContent;
            document.getElementById('editWilaya').value = cells[4].textContent;
            document.getElementById('editTypePrix').value = cells[5].textContent;
            document.getElementById('editValeur').value = cells[6].textContent;
            document.getElementById('editDeduction').value = cells[7].textContent;
            document.getElementById('editMontantNette').value = cells[8].textContent;
            document.getElementById('editCompetition').value = cells[9].textContent;
            document.getElementById('editNiveauCompetition').value = cells[10].textContent;
            document.getElementById('editSituation').value = cells[11].textContent;
            document.getElementById('editDateKhalass').value = cells[12].textContent;
            document.getElementById('editCheque').value = cells[13].textContent;
            document.getElementById('editBanque').value = cells[14].textContent;
            document.getElementById('editEtatEnvoiExpert').value = cells[15].textContent;
            document.getElementById('editRDV').value = cells[16].textContent;
            document.getElementById('editCompte').value = cells[17].textContent;
            document.getElementById('editAnneeComptable').value = cells[18].textContent;

            // Afficher le formulaire de modification
            document.getElementById('editForm').style.display = 'block';
        }
            // Fonction pour gérer la soumission du formulaire de modification
            function submitEditForm() {
           // Masquer le formulaire de modification après la soumission
            document.getElementById('editForm').style.display = 'none';
        }
        function closeEditForm() {
  // Masquer le formulaire de modification
  document.getElementById('editForm').style.display = 'none';
}
        // Fonction pour gérer la suppression d'un enregistrement
        function deleteRow(id) {
        if (confirm("Voulez-vous vraiment supprimer cet ligne ?")) {
            // Faire une requête pour supprimer l'enregistrement du serveur
            const xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", `delete_entry.php?id=${id}`, true);
            xmlhttp.send();

            // Recharger la page pour mettre à jour le tableau après la suppression
            location.reload();
        }
    }
    
function validateForm() {
    var editDate = document.getElementById("editDate").value;
    var editNumeroAppel = document.getElementById("editNumeroAppel").value;
    var editNomPrenom = document.getElementById("editNomPrenom").value;
    var editCIN = document.getElementById("editCIN").value;
    var editValeur = document.getElementById("editValeur").value;
    var editDeduction = document.getElementById("editDeduction").value;
    var editMontantNette = document.getElementById("editMontantNette").value;
    var editDateKhalass = document.getElementById("editDateKhalass").value;
    var editCheque = document.getElementById("editCheque").value;
    var editRDV = document.getElementById("editRDV").value;
    var editCompte = document.getElementById("editCompte").value;
    var editAnneeComptable = document.getElementById("editAnneeComptable").value;

    if (editDate === "" || editNumeroAppel === "" || editNomPrenom === "") {
        alert("Veuillez remplir tous les champs obligatoires.");
        return false;
    }

    if (isNaN(editNumeroAppel )) {
        alert("Le numéro d'appel doit être un nombre .");
        return false;
    }

    if (isNaN(editCIN) || editCIN.length !== 8) {
        alert("Le numéro de CIN doit être un nombre de 8 chiffres.");
        return false;
    }

    if (isNaN(editValeur) || isNaN(editDeduction) || isNaN(editMontantNette)) {
        alert("Les champs de valeur, déduction et montant nette doivent être des nombres.");
        return false;
    }

    if (!isValidDateFormat(editDate) ) {
        alert("Le format de date doit être DD-MM-YYYY.");
        return false;
    }

    if (isNaN(editCheque) || isNaN(editCompte)) {
        alert("Les champs de chèque et compte doivent être des nombres.");
        return false;
    }

    

    return true; // Permet au formulaire de se soumettre si toutes les validations sont passées
}

function isValidDateFormat(dateString) {
    var datePattern = /^\d{4}-\d{2}-\d{2}$/;
    return datePattern.test(dateString);
}

function validateAddForm() {
    var date = document.getElementById("date").value;
    var numeroAppel = document.getElementById("numero_appel").value;
    var nomPrenom = document.getElementById("nom_prenom").value;
    var cin = document.getElementById("cin").value;
    var valeur = document.getElementById("valeur").value;
    var deduction = document.getElementById("deduction").value;
    var montantNette = document.getElementById("montant_nette").value;
    var dateKhalass = document.getElementById("date_khalass").value;
    var cheque = document.getElementById("cheque").value;
    var compte = document.getElementById("compte").value;
    var anneeComptable = document.getElementById("annee_comptable").value;

    if (date === "" || numeroAppel === "" || nomPrenom === "" || cin === "") {
        alert("Veuillez remplir tous les champs obligatoires.");
        return false;
    }

    if (isNaN(numeroAppel) ) {
        alert("Le numéro d'appel doit être un nombre .");
        return false;
    }

    if (cin !== "" && (isNaN(cin) || cin.length !== 8)) {
        alert("Le numéro de CIN doit être un nombre de 8 chiffres.");
        return false;
    }

    if (isNaN(valeur) || isNaN(deduction) || isNaN(montantNette)) {
        alert("Les champs de valeur, déduction et montant net doivent être des nombres.");
        return false;
    }

    if (!isValidDateFormat(date)) {
        alert("Le format de date doit être YYYY-MM-DD.");
        return false;
    }

    if (isNaN(cheque) || isNaN(compte)) {
        alert("Les champs de chèque et compte doivent être des nombres.");
        return false;
    }

    return true; // Permet au formulaire de se soumettre si toutes les validations sont passées
}

function isValidDateFormat(dateString) {
    var datePattern = /^\d{4}-\d{2}-\d{2}$/;
    return datePattern.test(dateString);
}



    </script>
</head>
<body>
<nav class="navbar">
    <div class="logo-container">
        <img src="https://d11d9oqz0intmj.cloudfront.net/KzlXCGVmMySSoZW.png" alt="Mon logo">
    </div>
    <div class="nav-links">
        <a href="inscp.php">Créer un compte</a>
        <a href="?logout=true">Déconnexion</a>
    </div>
</nav>

</body>
        <h1>Tableau des gagnants</h1>
    <div class="table-container">
        <table>
            <tr>
                <!-- En-têtes du tableau -->
                <th>التاريخ</th>
                <th>رقم النداء</th>
                <th>اسم و لقب الفائز</th>
                <th>عدد بطاقة التعريف الوطنية</th>
                <th>الولاية</th>
                <th>نوع الجائزة</th>
                <th>القيمة</th>
                <th>الخصم</th>
                <th>الصافي</th>
                <th>المسابقة</th>
                <th>مستوى المسابقة</th>
                <th>الوضعية</th>
                <th>تاريخ الخلاص</th>
                <th>الصك</th>
                <th>البنك</th>
                <th>Etat Envoi Expert</th>
                <th>RDV</th>
                <th>Compte</th>
                <th>Année Comptable</th>
                <th>Actions</th>
            </tr>
            <?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "table_gagnants";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("La connexion à la base de données a échoué: " . mysqli_connect_error());
}

$sql = "SELECT * FROM table_gagnants";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $date_gagnant = new DateTime($row["date_gagnant"]);
        $current_date = new DateTime();

        $difference_in_months = $current_date->diff($date_gagnant)->m;

        $rowClass = '';
        if ($difference_in_months > 6) {
            $rowClass = 'red-row';
        } elseif (($row["situation"] == "payé" || $row["situation"] == "paye")) {
            $rowClass = 'green-row';
        } elseif ($difference_in_months <= 6) {
            $rowClass = 'yellow-row';
        }
        $timestamp=strtotime($row["date_gagnant"]);
        $date_limite=strtotime(" -6 month");
        $date_limite2=strtotime(" -12 month");
        $style=($timestamp <$date_limite2)?"background-color: red;":(($timestamp<$date_limite)?"background-color: yellow;":"");
        echo "<tr data-id='{$row["id"]}' style='$style '>";
        echo "<td class='{$rowClass}'>" . $row["date_gagnant"] . "</td>";
        echo "<td>".$row["numero_appel"]."</td>";
        echo "<td>".$row["nom_prenom"]."</td>";
        echo "<td>".$row["cin"]."</td>";
        echo "<td>".$row["wilaya"]."</td>";
        echo "<td>".$row["type_prix"]."</td>";
        echo "<td>".$row["valeur"]."</td>";
        echo "<td>".$row["deduction"]."</td>";
        echo "<td>".$row["montant_nette"]."</td>";
        echo "<td>".$row["competition"]."</td>";
        echo "<td>".$row["niveau_competition"]."</td>";
        echo "<td>".$row["situation"]."</td>";
        echo "<td>".$row["date_khalass"]."</td>";
        echo "<td>".$row["cheque"]."</td>";
        echo "<td>".$row["banque"]."</td>";
        echo "<td>".$row["etat_envoi_expert"]."</td>";
        echo "<td>".$row["rdv"]."</td>";
        echo "<td>".$row["compte"]."</td>";
        echo "<td>".$row["annee_comptable"]."</td>";
        echo '<td class="actions">';
        echo '<button class="action-btn edit-btn" onclick="editRow('.$row["id"].')">Modifier</button>';
        echo '<button class="action-btn delete-btn" onclick="deleteRow('.$row["id"].')">Supprimer</button>';
        echo '<button class="action-btn add-btn" onclick="showAddForm()">Ajouter</button>';
        echo '</td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='19'>Aucune donnée trouvée dans la base de données.</td></tr>";
}
mysqli_close($conn);
?>


            
        </table>
    </div>


        <!-- Formulaire d'ajout -->
        <div class="form-container" id="addForm" style="display: none;">
            <h2>Ajouter un gagnant</h2>
             <form id="actualAddForm" method="POST" action="insert_entry.php">
            <?php if (!empty($erreursValidation)): ?>
        <div class="message-erreur">
            <p>Il y a des erreurs dans le formulaire :</p>
            <ul>
                <?php foreach ($erreursValidation as $erreur): ?>
                    <li><?= $erreur ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">التاريخ:</label>
                        <input type="date" id="date" name="date" required >
                    </div>

                    <div class="form-group">
                        <label for="numero_appel">رقم النداء:</label>
                        <input type="bigint" id="numero_appel" name="numero_appel" required>
                    </div>
                    <div class="form-group">
                        <label for="nom_prenom">اسم و لقب الفائز:</label>
                        <input type="varchar" id="nom_prenom" name="nom_prenom" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="cin">عدد بطاقة التعريف الوطنية:</label required>
                        <input type="bigint" id="cin" name="cin">
                    </div>
                    <div class="form-group">
                        <label for="wilaya">الولاية:</label>
                        <input type="varchar" id="wilaya" name="wilaya">
                    </div>
                    <div class="form-group">
                        <label for="type_prix">نوع الجائزة:</label>
                        <input type="varchar" id="type_prix" name="type_prix">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="valeur">القيمة:</label>
                        <input type="decimal" id="valeur" name="valeur">
                    </div>
                    <div class="form-group">
                        <label for="deduction">الخصم:</label>
                        <input type="decimal" id="deduction" name="deduction">
                    </div>
                    <div class="form-group">
                        <label for="montant_nette">الصافي:</label>
                        <input type="decimal" id="montant_nette" name="montant_nette">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="competition">المسابقة:</label>
                        <input type="varchar" id="competition" name="competition">
                    </div>
                    <div class="form-group">
                        <label for="niveau_competition">مستوى المسابقة:</label>
                        <input type="varchar" id="niveau_competition" name="niveau_competition">
                    </div>
                    <div class="form-group">
                        <label for="situation">الوضعية:</label>
                        <input type="varchar" id="situation" name="situation">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="date_khalass">تاريخ الخلاص:</label>
                        <input type="date" id="date_khalass" name="date_khalass">
                    </div>
                    <div class="form-group">
                        <label for="cheque">الصك:</label>
                        <input type="bigint" id="cheque" name="cheque">
                    </div>
                    <div class="form-group">
                        <label for="banque">البنك:</label>
                        <input type="varchar" id="banque" name="banque">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="etat_envoi_expert">Etat Envoi Expert:</label>
                        <input type="varchar" id="etat_envoi_expert" name="etat_envoi_expert">
                    </div>
                    <div class="form-group">
                        <label for="rdv">RDV:</label>
                        <input type="date" id="rdv" name="rdv">
                    </div>
                    <div class="form-group">
                        <label for="compte">Compte:</label>
                        <input type="bigint" id="compte" name="compte">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="annee_comptable">Année Comptable:</label>
                        <input type="date" id="annee_comptable" name="annee_comptable">
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="return validateAddForm()">Ajouter</button>
                        <button type="button" onclick="closeAddForm()">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
 <!-- Formulaire de modification -->
        <div class="edit-form" id="editForm" style="display: none;">
    <h2>Modifier un gagnant</h2>
    <form action="update_entry.php" method="post">
        <div class="form-group">
            <input type="hidden" id="editId" name="editId">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editDate">التاريخ:</label>
                <input type="date" id="editDate" name="editDate" required>
            </div>
            <div class="form-group">
                <label for="editNumeroAppel">رقم النداء:</label>
                <input type="text" id="editNumeroAppel" name="editNumeroAppel" required>
            </div>
            <div class="form-group">
                <label for="editNomPrenom">اسم و لقب الفائز:</label>
                <input type="text" id="editNomPrenom" name="editNomPrenom" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editCIN">عدد بطاقة التعريف الوطنية:</label>
                <input type="text" id="editCIN" name="editCIN"required>
            </div>
            <div class="form-group">
                <label for="editWilaya">الولاية:</label>
                <input type="text" id="editWilaya" name="editWilaya">
            </div>
            <div class="form-group">
                <label for="editTypePrix">نوع الجائزة:</label>
                <input type="text" id="editTypePrix" name="editTypePrix">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editValeur">القيمة:</label>
                <input type="text" id="editValeur" name="editValeur">
            </div>
            <div class="form-group">
                <label for="editDeduction">الخصم:</label>
                <input type="text" id="editDeduction" name="editDeduction">
            </div>
            <div class="form-group">
                <label for="editMontantNette">الصافي:</label>
                <input type="text" id="editMontantNette" name="editMontantNette">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editCompetition">المسابقة:</label>
                <input type="text" id="editCompetition" name="editCompetition">
            </div>
            <div class="form-group">
                <label for="editNiveauCompetition">مستوى المسابقة:</label>
                <input type="text" id="editNiveauCompetition" name="editNiveauCompetition">
            </div>
            <div class="form-group">
                <label for="editSituation">الوضعية:</label>
                <input type="text" id="editSituation" name="editSituation">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editDateKhalass">تاريخ الخلاص:</label>
                <input type="date" id="editDateKhalass" name="editDateKhalass">
            </div>
            <div class="form-group">
                <label for="editCheque">الصك:</label>
                <input type="text" id="editCheque" name="editCheque">
            </div>
            <div class="form-group">
                <label for="editBanque">البنك:</label>
                <input type="text" id="editBanque" name="editBanque">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editEtatEnvoiExpert">Etat Envoi Expert:</label>
                <input type="text" id="editEtatEnvoiExpert" name="editEtatEnvoiExpert">
            </div>
            <div class="form-group">
                <label for="editRDV">RDV:</label>
                <input type="text" id="editRDV" name="editRDV">
            </div>
            <div class="form-group">
                <label for="editCompte">Compte:</label>
                <input type="text" id="editCompte" name="editCompte">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="editAnneeComptable">Année Comptable:</label>
                <input type="text" id="editAnneeComptable" name="editAnneeComptable">
            </div>
            <div class="form-group">
                <button type="submit" onclick="return validateForm()">Enregistrer</button>
                <button type="button" onclick="closeEditForm()">Annuler</button>
            </div>
        </div>
    </form>
</div>



    </div>
</body>
</html>  