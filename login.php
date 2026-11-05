
<?php
session_start();
require_once 'db.php';

$error = '';

if (isset($_SESSION['username'])) {
    header("Location: view.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {

        $error = "Please enter username and password.";

    } else {

        $sql = "SELECT user_id, user_name, password, role
                FROM users
                WHERE user_name = ?
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            if ($user) {

                $passwordCorrect =
                    password_verify($password, $user['password']) ||
                    hash_equals((string)$user['password'], (string)$password);

                if ($passwordCorrect) {

                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['user_name'];
                    $_SESSION['role'] = $user['role'];

                    mysqli_stmt_close($stmt);

                    header("Location: view.php");
                    exit;

                } else {

                    $error = "Incorrect password.";

                }

            } else {

                $error = "Account not found! Please create an account.";

            }

            mysqli_stmt_close($stmt);

        } else {

            $error = "Database query error.";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | LOL School</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-page">

<main class="login-card">

 

    <h1><b><i><u>Lol School Management </i> </u></b></h1><br>

    <h2>Welcome Back!</h2><br>

    <?php if ($error != ''): ?>
        <p class="message error">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="login.php">

        <div class="form-group">
            <label for="username">Username</label>

            <input
                type="text"
                id="username"
                name="username"
                placeholder="Enter your username"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit" class="login-btn">
            Login
        </button>

    </form>

    <div class="signup-link">
        <p>Don't have an account?</p>

        <a href="users.php" class="create-account"
   style="display:inline-block;
          background-color:#28a745;
          color:white;
          padding:12px 25px;
          text-decoration:none;
          border-radius:8px;
          font-size:16px;
          font-weight:bold;
          margin-top:10px;">
    Create Account
</a>
    </div>

   

</main>

</body>
</html>
