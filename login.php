<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input:focus {
            border-color: #007bff;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .link-btn {
            margin-top: 10px;
            text-align: center;
        }
        .link-btn a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        .link-btn a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>User Login</h2>
    <?php
    $error = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $dataFile = 'users.txt';

        if (empty($username) || empty($password)) {
            $error = "Username and password are required!";
        } else {
            $isValid = false;
            if (file_exists($dataFile)) {
                $file = fopen($dataFile, 'r');
                while (($line = fgets($file)) !== false) {
                    $userData = explode(',', trim($line));
                    if ($userData[2] === $username && $userData[3] === $password) {
                        $isValid = true;
                        session_start();
                        $_SESSION['username'] = $username;
                        $_SESSION['firstname'] = $userData[0];
                        $_SESSION['lastname'] = $userData[1];
                        fclose($file);
                        header("Location: profile.php");
                        exit;
                    }
                }
                fclose($file);
            }
            if (!$isValid) {
                $error = "Invalid username or password!";
            }
        }
    }
    ?>
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit">Login</button>
    </form>
    <div class="link-btn">
        <p>Don't have an account? <a href="registration.php">Register here</a></p>
    </div>
</div>
</body>
</html>
