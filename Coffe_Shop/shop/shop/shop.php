<?php

session_start();

if(!isset($_SESSION['emri'])){
    header("Location: ../../LoginPage/index.php");
    exit();
}

$alertMessage = '';


$dbconn = mysqli_connect("localhost", "root", '', 'coffeshop');
if (!$dbconn) {
    $alertMessage = "Nuk mund te lidhemi me te dhenat";
    exit;
}

if (isset($_POST['ruaj'])) {
    $emri = $_SESSION['emri'];
    $email = $_SESSION['email'];
    $fjalkalimi = $_SESSION['fjalkalimi'];
    $todayDate = date("Y-m-d");

    $dataOrder = $_POST['datacontent'];

    $orders = explode("\n", trim($dataOrder));

    if (empty($dataOrder)) {
        $alertMessage = "Nuk keni zgjedhur porosin";
    } else {
        foreach ($orders as $order) {
            $order = trim($order);
            if (!empty($order)) {
                $sql = "INSERT INTO porosit (porosia, dataporosis, emri, email, fjalkalimi)
                 VALUES ('$order', '$todayDate', '$emri','$email','$fjalkalimi')";
                if (!mysqli_query($dbconn, $sql)) {
                    $alertMessage = "Diqka shkoi gabim " . mysqli_error($dbconn);
                    exit;
                } else {
                    echo "<script>Porosia perfundoi me sukses</script>";
                }
            }
        }

        echo "<script>alert('Porosia perfundoi me sukses');</script>";
    }
}


if (!empty($alertMessage)) {
    echo "<script>alert('$alertMessage');</script>";
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="shop_style.css">
    <title>Coffe Shop</title>
    <script src="shopp.js"></script>
</head>

<body>

    <div class="container">
        <div class="left">
            <div>
                <h2>
                    <?php

                    if (isset($_SESSION['emri'])) {
                        echo $_SESSION['emri'];
                    }

                    if (isset($_POST['dil'])) {

                        session_unset();

                        session_destroy();

                        header("Location: ../../LoginPage/index.php");
                        exit;
                    }
                    ?>
                </h2>
            </div>
            <div>
                <a href=""><i class='bx bx-menu'></i></a>
                <a href="../save_data/db.php"><i class='bx bx-line-chart'></i></a>
                <form method="post">
                    <input type="submit" name="dil" id="dil" value="DIL">
                </form>
            </div>
        </div>
        <div class="mid">
            <div class="top">
                <div id="showhotcoffe">
                    <h3>KAFE TE NXEHTA</h3>
                </div>
                <div id="showcoldcoffe">
                    <h3>KAFE TE FTOHTA</h3>
                </div>
            </div>
            <div class="midcontainer" id="hotcoffe">
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/flatewhite.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Flat White</h3>
                    </div>
                    <div class="price">
                        <h3>2.99€</h3>
                        <button id="flatewhite">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/caffelate.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Caffe Late</h3>
                    </div>
                    <div class="price">
                        <h3>1.49€</h3>
                        <button id="caffelate">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/cappuccino.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Cappuccino</h3>
                    </div>
                    <div class="price">
                        <h3>1.00€</h3>
                        <button id="cappuccino">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images//mocha.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Mocha</h3>
                    </div>
                    <div class="price">
                        <h3>1.50€</h3>
                        <button id="mocha">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/americano.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Americano</h3>
                    </div>
                    <div class="price">
                        <h3>1.20€</h3>
                        <button id="americano">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/caramelmacchiato.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Caramel Macchiato</h3>
                    </div>
                    <div class="price">
                        <h3>3.00€</h3>
                        <button id="caramelmacchiato">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/expresso.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Expresso</h3>
                    </div>
                    <div class="price">
                        <h3>1.20€</h3>
                        <button id="expresso">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/parisianchocolate.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Parisian Chocolate</h3>
                    </div>
                    <div class="price">
                        <h3>2.59€</h3>
                        <button id="parisianchocolate">SHTO</button>
                    </div>
                </div>
            </div>
            <div class="midcontainer" id="coldcoffe">
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/coldcoffe.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Cold coffe</h3>
                    </div>
                    <div class="price">
                        <h3>2.45€</h3>
                        <button id="cold-coffe">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/oreocoffe.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Oreo Ice coffe</h3>
                    </div>
                    <div class="price">
                        <h3>3.15€</h3>
                        <button id="oreocoffe">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/frapuccino.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Frapuccino</h3>
                    </div>
                    <div class="price">
                        <h3>2.49€</h3>
                        <button id="frapuccino">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/spanishlatte.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Spanish Latte</h3>
                    </div>
                    <div class="price">
                        <h3>1.99€</h3>
                        <button id="spanishlatte">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/chocolatecappucino.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3 style="font-size: 20px;">Chocolate Capuccino</h3>
                    </div>
                    <div class="price">
                        <h3>1.20€</h3>
                        <button id="chocolatecappucino">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/glacecoffe.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Glace Coffe</h3>
                    </div>
                    <div class="price">
                        <h3>3.20€</h3>
                        <button id="glacecoffe">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/rafcoffe.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Raf Coffe</h3>
                    </div>
                    <div class="price">
                        <h3>2.80€</h3>
                        <button id="rafcoffe">SHTO</button>
                    </div>
                </div>
                <div class="item" id="item">
                    <div class="img">
                        <img src="images/marocchinocoffe.jpg" alt="">
                    </div>
                    <div class="name">
                        <h3>Marocchino Coffe</h3>
                    </div>
                    <div class="price">
                        <h3>3.59€</h3>
                        <button id="maocchinocoffe">SHTO</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="right">
            <div class="top">
                <h2>FATURA</h2>
            </div>
            <div>
                <h4>Sasia</h4>
                <h4>Emri</h4>
                <h4>Cmimi</h4>
                <h4>Fshij</h4>
            </div>
            <div>
                <hr>
            </div>
            <div class="mid" id="orderList">


            </div>
            <div class="totalprice">
                <h3 class="total">Total: 0.00€</h3>
            </div>
            <div class="bottom">
                <form method="post">
                    <input type="submit" name="ruaj" id="ruaj" value="RUAJ">
                    <input type="hidden" id="datacontent" name="datacontent">
                </form>
                <button id="fshij">FSHIJ</button>
                <button id="printo">PRINTO</button>
            </div>
        </div>
    </div>
</body>

</html>