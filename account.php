<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
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


$data = "SELECT name,email,city,phone,password FROM users WHERE email='$_SESSION[acc]'";
$result = mysqli_query($conn, $data);
if ($result->num_rows > 0)
    $row = $result->fetch_assoc();
if (isset($_POST['delete']) && $_POST['delete']!='sankalp.singh117@gmail.com') {
    $name1 = str_replace("@", "_", $_SESSION['acc']);
    $name2 = str_replace(".", "_", $name1);
    mysqli_query($conn, "DROP TABLE $name2");
    mysqli_query($conn, "DELETE FROM users WHERE email='$_POST[delete]'");
    header("Location:signup.php");
}
else{
if(isset($_POST['delete']))
echo "<center><p style='color:red;'>Can't Delete Superuser</center>";
}

if (isset($_POST['password'])) {
    if($_POST['password']!='null' && $_POST['password']!=""){
    mysqli_query($conn, "UPDATE users SET password='$_POST[password]' WHERE email='$_SESSION[acc]'");
    header("Location:account.php");}
}
?>

<body style="background-color: lightgrey;">
    <button class="bg-indigo-400 ml-8 p-2 text-white hover:bg-indigo-500" onclick="window.location.href='home.php'">Home</button>
    <div class="bg-white rounded-lg w-4/5 m-auto mt-5 p-5">
        <p class="text-2xl text-center font-bold">USER DETAILS</p><br>
        <div class="w-fit m-auto">
            <div>Name - <?php echo $row['name'] ?></div>
            <div>Email - <?php echo $row['email'] ?></div>
            <div>City - <?php echo $row['city'] ?></div>
            <div>Phone - <?php echo $row['phone'] ?></div>
            <div>Password - <?php echo $row['password'] ?>
                <br>
                <form method="post"><button class="text-blue-400" name="password" onclick="value=prompt('Enter New Password')">Change Password</button></form>
            </div>
        </div>
        <div class="w-fit m-auto mt-8">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" ) method="post">
                <button class='bg-red-400 hover:bg-red-500 p-2 text-white' value="<?php echo htmlspecialchars($_SESSION['acc']) ?>" name="delete">Delete Account</button>
            </form>
        </div>
    </div>

</body>

</html>