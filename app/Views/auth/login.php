<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/<?= PROJECT_NAME ?>/public/css/auth/login.css">
</head>
<body>
    <div class="main-content">
        <div class="login-container">
            <h2>LOGIN</h2>
            <form action="/<?= PROJECT_NAME ?>/login" method="post">
                <label for="email">Email: *</label>
                <input type="email" id="email" name="email" placeholder="Email">
                <br>
                <label for="password">Password: *</label>
                <input type="password" name="password" placeholder="Password">
                <br>
                <button type="submit">Login</button>
            </form>

            <p>
                Don't have an account?
                <a href="/<?= PROJECT_NAME ?>/register">Register</a>
            </p>
        </div>
    </div>
</body>
</html>