<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="stylee.css">
    <title>Login Page</title>
</head>

<?php
session_start(); 

$alertMessage = "";
?>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <?php
            if (isset($_POST['signup'])) {
                $dbconn = mysqli_connect("localhost", "root", "", "coffeshop");
                if (!$dbconn) {
                    die("Gabim në lidhjen me bazën e të dhënave: " . mysqli_error($dbconn));
                }

                $name = $_POST['name'];
                $email = $_POST['email'];
                $fjalkalimi = $_POST['password'];

                $sql = "SELECT * FROM users WHERE email = '$email'";
                $res = mysqli_query($dbconn, $sql);

                if (mysqli_num_rows($res) == 0) {
                    $sql = "INSERT INTO users(emri, email, fjalkalimi) VALUES ('$name', '$email', '$fjalkalimi')";
                    $res = mysqli_query($dbconn, $sql);
                    if ($res) {
                        $alertMessage = "U regjistruat me sukses!";
                    } else {
                        $alertMessage = "Gabim gjatë regjistrimit!";
                    }
                } else {
                    $alertMessage = "Ky email është i regjistruar!";
                }
            }

            if (!empty($alertMessage)) {
                echo "<script>alert('$alertMessage');</script>";
            }
            ?>
            <form method="post">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" placeholder="Name" name="name" autocomplete="off" required>
                <input type="email" placeholder="Email" name="email" autocomplete="off" required>
                <input type="password" placeholder="Password" name="password" autocomplete="off" required>
                <input type="submit" name="signup" id="signup" value="Sign up">
            </form>
        </div>

        <div class="form-container sign-in">
            <?php
            if (isset($_POST['signin'])) {
                $dbconn = mysqli_connect("localhost", "root", "", "coffeshop");
                if (!$dbconn) {
                    die("Gabim në lidhjen me bazën e të dhënave: " . mysqli_error($dbconn));
                }

                $email = $_POST['email'];
                $passwordi = $_POST['password'];

                $sql = "SELECT * FROM users WHERE email = '$email' AND fjalkalimi = '$passwordi'";
                $res = mysqli_query($dbconn, $sql);

                if (mysqli_num_rows($res) > 0) {
                    $klienti = mysqli_fetch_assoc($res);
                    $_SESSION['email'] = $klienti['email'];
                    $_SESSION['fjalkalimi'] = $klienti['fjalkalimi'];
                    $_SESSION['emri'] = $klienti['emri'];
                    header("Location: ../shop/shop/shop.php");
                    exit;
                } else {
                    $alertMessage = "Keni gabuar email ose passwordin!";
                }
            }

            if (!empty($alertMessage)) {
                echo "<script>alert('$alertMessage');</script>";
            }
            ?>
            <form method="post">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email and password</span>
                <input type="email" placeholder="Email" name="email" autocomplete="off" required>
                <input type="password" placeholder="Password" name="password" autocomplete="off" required>
                <a href="#">Forget Your Password?</a>
                <input type="submit" name="signin" id="signin" value="Sign in">
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>