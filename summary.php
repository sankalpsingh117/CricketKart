<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body style="background-color: lightgrey;">
    <p class='text-center text-3xl mt-8'>Thank You for Shopping with Cricket Kart<br><br>Your order would be delivered soon......</p>
    <?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "e_commerce";

    $conn = mysqli_connect($servername, $username, $password, $database);


    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $name1 = str_replace("@", "_", $_SESSION['acc']);
    $name2 = str_replace(".", "_", $name1);
    mysqli_query($conn, "TRUNCATE TABLE $name2");

    echo '<script>setTimeout(function(){window.location.href = 
    "home.php"}, 4 * 1000);</script>';
    ?>
</body>

</html>