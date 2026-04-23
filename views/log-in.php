<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Shift System</title>
    <link rel="stylesheet" href="../STYLES/log-in.css">
</head>
<body>

<div class="container">

    <div class="card">
        <h2 class="subtitle">Welcome back</h2>
        <h1 class="title">Shift-System</h1>

        <form class="formLog" method="POST" action="../controller/userController.php">

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="pass" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn">Login</button>

        </form>

        <p class="register-link">
            Don't have an account?
            <a href="reg.php">Register</a>
        </p>
    </div>

</div>

</body>
</html>