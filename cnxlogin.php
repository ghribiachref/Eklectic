<?php
session_start();

// Générer un jeton CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$hostname = 'localhost';
$username_db = 'root';
$password_db = '';
$database = 'table_gagnants';

$conn = mysqli_connect($hostname, $username_db, $password_db, $database);

if (!$conn) {
    die("Échec de la connexion à la base de données: " . mysqli_connect_error());
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'connexion') {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT id, password, role FROM users WHERE username = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) === 1) {
                mysqli_stmt_bind_result($stmt, $userId, $hashed_password, $role);
                mysqli_stmt_fetch($stmt);

                if (password_verify($password, $hashed_password)) {
                    // Générer un jeton CSRF
                    $csrf_token = bin2hex(random_bytes(32));
                    
                    // Stocker les informations de l'utilisateur dans la session
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    $_SESSION['csrf_token'] = $csrf_token;
                    
                    // Régénérer l'ID de session pour renforcer la sécurité
                    session_regenerate_id(true);

                    if ($role === 'admin') {
                        header('Location: admin_dashboard.php');
                    } elseif ($role === 'marketing user') {
                        header('Location: marketing_dashboard.php');
                    } elseif ($role === 'financier user') {
                        header('Location: financier_dashboard.php');
                    } else {
                        header('Location: default_dashboard.php');
                    }
                    exit();
                } else {
                    echo "Mot de passe incorrect.";
                }
            } else {
                echo "Nom d'utilisateur incorrect.";
            }
        } else {
            echo "Veuillez fournir un nom d'utilisateur et un mot de passe.";
        }
    }

    // ...
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
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
        input[type="password"] {
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
    <div class="logo-container">
        <img src="https://d11d9oqz0intmj.cloudfront.net/KzlXCGVmMySSoZW.png" alt="Mon logo">
    </div>

    <div class="container">
        <h2>Login</h2>
        <form id="loginForm" method="post">
    <input type="hidden" name="action" value="connexion">
    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">


    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>




    </div>
</body>
</html>