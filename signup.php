<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favi.png">
    <title>Sign Up</title>
</head>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "e_commerce";

$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_REQUEST['email'])) {
    $count = 0;
    $name = $_POST["name"];
    $email = $_POST["email"];
    $city = $_POST["city"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $name1 = str_replace("@", "_", $email);
    $name2 = str_replace(".", "_", $name1);
    $sql = "INSERT INTO users (name,email,city,phone,password) VALUES ('$name','$email','$city','$phone','$password')";
    $cart = "CREATE TABLE $name2 (
    name VARCHAR(30),
    price VARCHAR(30),
    quantity VARCHAR(30)
    )";
    $chk = "SELECT email FROM users";
    $result = mysqli_query($conn, $chk);
}

?>

<body>
    <script>
        function empty() {
            if (document.getElementById('input1').value == "") {
                document.getElementById("err").innerHTML = "Enter Name";
                event.preventDefault();
            } else if (document.getElementById('input2').value == "") {
                document.getElementById("err").innerHTML = "Enter Email";
                event.preventDefault();
            } else if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.getElementById("input2").value)) {
                document.getElementById("err").innerHTML = "Enter Valid Email";
                event.preventDefault();
            } else if (document.getElementById('input3').value == "") {
                document.getElementById("err").innerHTML = "Enter City";
                event.preventDefault();
            } else if (document.getElementById('input4').value == "") {
                document.getElementById("err").innerHTML = "Enter Phone";
                event.preventDefault();
            } else if (document.getElementById('input5').value == "") {
                document.getElementById("err").innerHTML = "Enter Password";
                event.preventDefault();
            } else if (document.getElementById('input6').value == "") {
                document.getElementById("err").innerHTML = "Confirm Password";
                event.preventDefault();
            } else if (document.getElementById('input5').value != document.getElementById('input6').value) {
                document.getElementById("err").innerHTML = "Password Dosen't Match";
                event.preventDefault();
            } else if (document.getElementById('input5').value.length < 6) {
                document.getElementById("err").innerHTML = "Password Should Contain Atleast Six Characters";
                event.preventDefault();
            }

        }
    </script>
    <style>
        a {
            margin: 0px 15%;
        }

        body {
            background-color: lightgray;
        }

        .main {
            background-color: white;
            width: 27%;
            margin: auto;
            margin-top: 30px;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            border-radius: 5px;

        }

        #btn {
            background-color: #818cf8;
            color: rgb(255, 255, 255);
            margin: 25px 23%;
            width: 50%;
            height: 40px;
            border-radius: 5px;
            border-color: #818cf8;

        }

        #btn:hover {
            background-color: #6366f1;
            border-color: #6366f1;
            cursor: pointer;

        }

        .input {
            width: 65%;
            height: 35px;
            margin: 12px 15%;
        }

        h2 {
            text-align: center;
            padding-top: 25px;

        }

        .label {
            margin: 15px 15%;
        }

        .signup {
            margin: 0px 33%;
            padding-bottom: 25px;

        }

        @media screen and (max-width: 650px) {
            .main {
                width: 70%;
            }
        }
    </style>
    <div class="main">
        <h2>SIGN UP</h2>
        <p id="err" style="color:red;text-align:center;">
            <?php
            if (isset($_REQUEST['email'])) {
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        if ($row['email'] == $email)
                            $count++;
                    }

                    if ($count > 0)
                        echo "User Already Registered<br>";

                    else {
                        if (mysqli_query($conn, $sql)) {
                            echo "New User Created<br>";
                            mysqli_query($conn, $cart);
                            unset($_POST['email']);
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                } else {
                    if (mysqli_query($conn, $sql)) {
                        echo "New User Created<br>";
                        mysqli_query($conn, $cart);
                        unset($_POST['email']);
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }
            ?>
        </p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <input id="input1" class="input" type="text" name="name" placeholder="Name"><br>
            <input id="input2" class="input" type="text" name="email" placeholder="Email"><br>
            <input id="input3" class="input" type="text" name="city" placeholder="City"><br>
            <input id="input4" class="input" type="text" name="phone" placeholder="Phone"><br>
            <input id="input5" class="input" type="password" name="password" placeholder="Password"><br>
            <input id="input6" class="input" type="password" name="confirm" placeholder="Confirm Password"><br>






            <button onclick="empty()" id="btn" type="submit">SIGN UP</button>
        </form>
        <div class="signup">
            <p>Had a account ?</p><a href="index.php">Sign In</a>
        </div>
    </div>


</body>

</html>