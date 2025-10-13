<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/<?= PROJECT_NAME ?>/public/css/auth/register.css">
</head>

<body>
    <div class="main-content">
        <div class="register-container">
            <h2>REGISTER</h2>
            <form action="/<?= PROJECT_NAME ?>/register" method="post">
                <div>
                    <div>
                        <label for="first_name">First name: *</label>
                        <input type="text" name="first_name" id="first_name" placeholder="First name">
                    </div>

                    <div>
                        <label for="last_name">Last name: *</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Last name">
                    </div>

                    <div>
                        <label for="email">Email: * </label>
                        <input type="text" name="email" id="email" placeholder="email">
                    </div>

                    <div>
                        <label for="gender">Gender: *</label>
                        <div class="gender-group">
                            <label>
                                <input type="radio" name="gender" value="male" required> Male
                            </label>
                            <label>
                                <input type="radio" name="gender" value="female"> Female
                            </label>
                            <label>
                                <input type="radio" name="gender" value="other"> Other
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="city">City: * </label>
                        <input type="text" name="city" id="city" placeholder="City">
                    </div>

                    <div>
                        <label for="street">Street: * </label>
                        <input type="text" name="street" id="street" placeholder="Street">
                    </div>

                    <div>
                        <label for="password">Password: *</label>
                        <input type="password" name="password" id="password" placeholder="password">
                    </div>

                    <div>
                        <label for="password-confirmation">Password confirm: *</label>
                        <input type="password" name="password-confirmation" id="password-confirmation" placeholder="Confirm your password">
                    </div>
                </div>

                <div>
                    <button class="submit-btn" type="submit">Register</button>
                </div>
            </form>
            <p>
                Already have an account?
                <a href="/<?= PROJECT_NAME ?>/login">Login</a>
            </p>
        </div>
    </div>
</body>

</html>