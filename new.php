<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] === 'inscription') {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "table_gagnants";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Échec de la connexion à la base de données: " . mysqli_connect_error());
    }

    // Vérifier si une administratrice a déjà été créée
    $adminCreated = false;
    $checkQuery = "SELECT COUNT(*) AS admin_count FROM users WHERE role = 'admin'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if ($checkResult) {
        $adminCount = mysqli_fetch_assoc($checkResult)['admin_count'];
        if ($adminCount > 0) {
            $adminCreated = true;
        }
    }

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Vérifier si l'username se termine par "@admin.tn" pour le compte administrateur
        if ($adminCreated && ($role === 'admin' || strpos($username, '@admin.tn') !== false)) {
            $_SESSION['error_message'] = "L'inscription de l'administratrice est déjà effectuée.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $role);

            if (mysqli_stmt_execute($stmt)) {
                if (!$adminCreated && $role === 'admin') {
                    // Mettre à jour la colonne admin_created dans la base de données
                    $updateQuery = "UPDATE users SET admin_created = 1 WHERE role = 'admin'";
                    mysqli_query($conn, $updateQuery);
                }
                $_SESSION['success_message'] = "Inscription réussie !";
                header('Location: new.php');
                exit();
            } else {
                $_SESSION['error_message'] = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
            }
        }
    } else {
        $_SESSION['error_message'] = "Veuillez fournir un nom d'utilisateur, un mot de passe et un rôle.";
    }

    mysqli_close($conn);
}

$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "";
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html>
<head>
    
    <!-- Your head content here -->
</head>
<body>
    <div class="container">
        
        <form action="new.php" method="post">
            <input type="hidden" name="action" value="inscription">
            
            <?php if (!empty($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
            <?php } ?>
            
            <!-- Your form fields here -->
            
            <?php if (!empty($_SESSION['success_message'])) { ?>
                <p style="color: green;"><?php echo $_SESSION['success_message']; ?></p>
                <?php unset($_SESSION['success_message']); ?>
            <?php } ?>
            
            <!-- Rest of your form and HTML content -->
        </form>
    </div>
</body>
</html>











<!DOCTYPE html>
<html>
<head>
    <title>Créer un compte</title>
    <div class="logo-container">
        <img src="https://d11d9oqz0intmj.cloudfront.net/KzlXCGVmMySSoZW.png" alt="Mon logo">
    </div>


    <style>
        /* Votre CSS ici */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            background-image: url('https://t3.ftcdn.net/jpg/03/55/60/70/360_F_355607062_zYMS8jaz4SfoykpWz5oViRVKL32IabTP.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 10%;
            padding: 20px;
            background-color: #e9e7fd82;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        select {
            width: 90%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-left: 1%;
        }
        button {
            display: block;
            width: 50%;
            padding: 8px;
            background-color: #1064beb7;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 25%;
        }
        button:hover {
            background-color: #0056b3;
        }
        #message {
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Create an Account</h2>
        <form action="new.php" method="post">
            <input type="hidden" name="action" value="inscription">
            
           
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                <option value="admin">Admin</option>
                <option value="marketing user">Marketing User</option>
                <option value="financier user">Financier User</option>
                </select>
            </div>
            
            <button type="submit">Register</button>
        </form>
        <p id="message"></p>
        <p class="create-account-text">Already have an account? <a href="cnxlogin.php">Login</a></p>
    </div>
</body>
</html>