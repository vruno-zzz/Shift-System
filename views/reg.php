<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Shift System</title>
    <link rel="stylesheet" href="../STYLES/reg.css">
</head>
<body>

<div class="container">

    <div class="card">
        <h2 class="subtitle">Create your account</h2>
        <h1 class="title">Shift-System</h1>

        <form class="formREG" method="POST" action="../controller/userController.php">

            <div class="input-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="pass" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn">Register</button>

        </form>

        <p class="login-link">
            Already have an account?
            <a href="log-in.php">Login</a>
        </p>
    </div>

</div>

</body>
</html>