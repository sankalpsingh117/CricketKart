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
$name1 = str_replace("@", "_", $_SESSION['acc']);
$name2 = str_replace(".", "_", $name1);
if (isset($_POST['remove'])) {
    mysqli_query($conn, "DELETE FROM $name2 WHERE name='$_POST[remove]'");
}
$crt = mysqli_query($conn, "SELECT name,price,quantity FROM $name2");

?>

<body style="background-color: lightgrey;">
    <button class="bg-indigo-400 ml-8 p-2 text-white hover:bg-indigo-500" onclick="window.location.href='home.php'">Home</button>

    <div class="bg-white w-4/5 m-auto mt-8 p-8 rounded-lg">
        <p class="text-center my-2 text-2xl font-bold mb-8">CART</p>
        <table class="m-auto">
            <tr class="bg-sky-200">
                <th class="px-2">Product</th>
                <th class="px-2">Quantity</th>
                <th class="px-2">Price</th>
                <th class="px-2">Total</th>
                <th class="px-2">Action</th>
            </tr>

            <?php
            $num4 = 0;
            if ($crt->num_rows > 0) {
                while ($row = $crt->fetch_assoc()) {
                    $num1 = $row['price'];
                    $num2 = $row['quantity'];
                    $num3 = $num1 * $num2;
                    $num4 = $num4 + $num3;

                    echo "<tr>
                <td class='px-2'>$row[name]</td>
                <td class='px-2'>$row[quantity]</td>
                <td class='px-2'>$row[price]</td>
                <td class='px-2'>$num3</td>
                <td class='px-2'>
                <form method='post'>
               <button class='bg-red-400 p-1 mt-1 hover:bg-red-500 text-white' name='remove' value='$row[name]'>Remove</button>
               </form></td>
            </tr>";
                }
            }
            ?>
        </table>
        <?php
        if ($crt->num_rows == 0)
            echo "<p class='text-center font-bold mt-4'>Cart is Empty</p>";
        ?>
        <div class="mt-8 w-80 m-auto">
            <?php
            if ($crt->num_rows > 0)
                echo "<div class='text-center mt-2 mb-8 font-bold w-fit ml-auto'>Grand Total $num4</div> 
            <div class='w-fit m-auto inline'><button onclick=\"location.href='summary.php'\" class='p-2 text-white bg-indigo-400 hover:bg-indigo-500'>Checkout</button></div>
            <div class='w-fit m-auto inline'><button class='bg-indigo-400 p-2 text-white hover:bg-indigo-500' onclick='window.print()'>Print Invoice</button><div>";
            ?>
        </div>
    </div>

</body>

</html>