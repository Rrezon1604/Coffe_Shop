<?php

session_start();

if (!isset($_SESSION['emri'])) {
    header("Location: ../../LoginPage/index.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dbStyle.css">
    <title>Coffe Shop</title>
    <script src="db.js"></script>

</head>

<body>
    <div class="container">
        <div class="left">
            <div>
                <h2>
                    <?php


                    echo $_SESSION['emri'];

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
                <a href="../shop/shop.php"><i class='bx bx-menu'></i></a>
                <a href=""><i class='bx bx-line-chart'></i></a>
                <form method="post">
                    <input type="submit" name="dil" id="dil" value="DIL">
                </form>
            </div>
        </div>
        <div class="mid">
            <div class="shfaq">
                <form method="post">
                    <input type="date" name="data" id="data">
                    <input type="submit" name="kerko" id="kerko" value="Kerko sipas dates">
                    <input type="submit" name="showall" id="showall" value="Shfaq te gjitha Porosit">
                </form>
            </div>
            <div class="porosia" id="porositPerPrintim">
                <?php
                $alertMessage = '';
                $totalCmimi = 0.0;
                $dataporosis = isset($_POST['data']) ? $_POST['data'] : '';

                if (isset($_SESSION['emri'], $_SESSION['email'])) {
                    $emri = $_SESSION['emri'];
                    $email = $_SESSION['email'];

                    $num = 0;
                    $dbconn = mysqli_connect("localhost", "root", '', 'coffeshop');
                    if (!$dbconn) {
                        $alertMessage = "Nuk mund të lidhemi me të dhënat";
                        exit;
                    }

                    // Fshirje e një porosie të vetme
                    if (isset($_POST['delete_id'])) {
                        $delete_id = $_POST['delete_id'];
                        $delete_sql = "DELETE FROM porosit WHERE porosiaid = '$delete_id' AND emri = '$emri' AND email = '$email'";
                        if (mysqli_query($dbconn, $delete_sql)) {
                            header("Refresh:0");
                            exit;
                        } else {
                            $alertMessage = "Diçka shkoi gabim gjatë fshirjes: " . mysqli_error($dbconn);
                        }
                    }

                    // Fshirje e të gjitha porosive
                    if (isset($_POST['fshij'])) {
                        $delete_all_sql = "DELETE FROM porosit WHERE email = '$email'";
                        if (mysqli_query($dbconn, $delete_all_sql)) {
                            $alertMessage = "Të gjitha të dhënat u fshinë me sukses.";
                        } else {
                            $alertMessage = "Diçka shkoi gabim gjatë fshirjes: " . mysqli_error($dbconn);
                        }
                    }

                    // Kontrollo nëse është shtypur butoni "Kerko" ose "Shfaq te gjitha"
                    if ((isset($_POST['kerko']) && !empty($dataporosis)) || isset($_POST['showall'])) {
                        // Përzgjedhja e të gjitha porosive nëse është shtypur "Shfaq te gjitha"
                        if ($email === 'rrezon.admin@gmail.com') {
                            // Nëse përdoruesi është admin, merrni të gjitha porositë
                            $sql = "SELECT * FROM porosit";
                        } else {
                            // Përzgjedhja e të gjitha porosive nëse është shtypur "Shfaq te gjitha"
                            if (isset($_POST['showall'])) {
                                $sql = "SELECT * FROM porosit WHERE emri = '$emri' AND email = '$email'";
                            } else {
                                $sql = "SELECT * FROM porosit WHERE emri = '$emri' AND email = '$email' AND dataporosis = '$dataporosis'";
                            }
                        }

                        $res = mysqli_query($dbconn, $sql);

                        if (!$res) {
                            $alertMessage = "Diçka shkoi gabim: " . mysqli_error($dbconn);
                        } else {
                            if (mysqli_num_rows($res) > 0) {
                                echo "<table class='no-border'>
                                <tr>
                                    <th>Sasia</th>";
                            // Shto kolonën për emrin vetëm për adminin
                            if ($email === 'rrezon.admin@gmail.com') {
                                echo "<th>Emri</th>";
                                echo "<th>Email</th>";
                            }
                            echo "<th>Porosia</th>
                                    <th>Çmimi</th>
                                    <th>Data</th>
                                    <th class='delete-column'>Delete</th>
                                </tr>";

                                while ($porosia = mysqli_fetch_assoc($res)) {
                                    $num += 1;
                                    $dataporosis = $porosia['dataporosis'];
                                    $porosiaText = preg_replace('/^\d+\s/', '', $porosia['porosia']);
                                    preg_match('/(.*?)(\d+\.\d{2}\€)/', $porosiaText, $matches);
                                    $porosiaText = $matches[1];
                                    $cmimi = isset($matches[2]) ? $matches[2] : '0.00';

                                    $totalCmimi += (float)$cmimi;

                                    echo "<tr>
                                    <td>$num</td>";
                                // Shto vlerën e emrit për çdo rresht për adminin
                                if ($email === 'rrezon.admin@gmail.com') {
                                    echo "<td>" . htmlspecialchars($porosia['emri']) . "</td>";
                                    echo "<td>" . htmlspecialchars($porosia['email']) . "</td>";
                                }
                                echo "<td>" . htmlspecialchars($porosiaText) . "</td>
                                    <td>" . htmlspecialchars($cmimi) . "</td>
                                    <td>" . htmlspecialchars($dataporosis) . "</td>
                                    <td>
                                        <form method='post' style='display:inline;'>
                                            <input type='hidden' name='delete_id' value='" . $porosia['porosiaid'] . "'>
                                            <input style='color:red;' class='delbutton' type='submit' value='DEL'>
                                        </form>
                                    </td>
                                </tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "<p style='margin-left:45%; margin-top: 20px; color:red;'>Nuk keni porosi ne kete date.</p>";
                            }
                        }
                    }

                    mysqli_close($dbconn);
                } else {
                    $alertMessage = "Ju lutem logohuni fillimisht.";
                }

                if ($alertMessage) {
                    echo "<div class='alert'>$alertMessage</div>";
                }

                ?>

            </div>
            <div class="cmimitotal" id="cmimitotal">
                <h3>Totali i porosive: <span> <?php echo number_format($totalCmimi, 2); ?>€ </span></h3>
            </div>
        </div>
        <div class="right">
            <div class="date">
                <h5>Data:</h5>
                <h4 id="currentDate"></h4>
            </div>
            <div class="buttons">
                <button id="ruaj">RUAJ</button>
                <form method="post">
                    <input type="submit" name="fshij" id="fshij" value="FSHIJ">
                </form>
                <button id="printo">PRINTO</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("printo").addEventListener("click", function() {
            var porositContent = document.getElementById("porositPerPrintim").innerHTML;
            var totalContent = document.querySelector(".cmimitotal").innerHTML;
            var emriKlientit = "<?php echo isset($_SESSION['emri']) ? $_SESSION['emri'] : 'Klient'; ?>";

            // Krijo një dritare të re për printim
            var printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`
        <html>
            <head>
                <title>Printo Porositë</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                    h3 { font-weight: bold; }
                    .delbutton { display: none; }
                    .delete-column { display:none; }
                </style>
            </head>
            <body>
                <h2>Porositë e Klientit: ${emriKlientit}</h2>
                ${porositContent}
                ${totalContent}
            </body>
        </html>
    `);
            printWindow.document.close();
            printWindow.print();

            printWindow.onafterprint = function() {
                printWindow.close();
            };
        });

        document.getElementById("ruaj").onclick = function() {
            alert("POROSIA JUAJ ESHTE RUAJTUR");
        }
    </script>

</body>

</html>