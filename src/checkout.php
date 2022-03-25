<?php include 'post.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="bg-gray-300">
                    <div class="">
                        <div class="max-w-md mx-auto bg-white shadow-lg rounded-lg md:max-w-xl mx-2">
                            <div class="md:flex ">
                                <div class="w-full p-4 px-5 py-5 text-center">
                                    <div class="flex flex-row">
                                        <h2 class="text-3xl font-semibold">checkout page</h2>
                                    </div>
                                    <div class="flex flex-row pt-2 text-xs pt-6 pb-5"> <span class="font-bold">Information</span> <small class="text-gray-400 ml-1">></small> <span class="text-gray-400 ml-1">Shopping</span> <small class="text-gray-400 ml-1">></small> <span class="text-gray-400 ml-1">Payment</span> </div> <span>Customer Information</span>
                                    <div class="relative pb-5"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="E-mail"> <span class="absolute text-blue-500 right-2 top-4 font-medium text-sm">Log out</span> </div> <span>Shipping Address</span>
                                    <div class="grid md:grid-cols-2 md:gap-2"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="First name*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Last name*"> </div> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Company (optional)"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Address*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Apartment, suite, etc. (optional)">
                                    <div class="grid md:grid-cols-3 md:gap-2"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Zipcode*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="City*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="State*"> </div> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Country*"> <input type="text" name="mail" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Phone Number*">
                                    <form action="" method="POST">
                                        <div class="flex justify-between text-center items-center pt-2"> <a href="cart.php" class="btn btn-lg bg-dark text-muted mt-3 h-12 w-24 text-blue-500 text-xs font-medium">Return to cart</a> <button type="submit" name="place_order" class="btn btn-lg bg-dark text-muted mt-3 h-12 w-48 rounded font-medium text-xs bg-blue-500 ">Continue to Shipping</button> </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-5">
                <h4>YOUR CART:</h4>
                <div>
                    <?php
                    if (isset($_POST['buyall'])) {
                        display_cart();


                    ?>
                </div>
                <div>
                    <span>TOTAL ITEMS: </span>
                    <?php
                        cart_count();
                    ?>
                </div>
                <div>
                <?php
                        total_price();
                    }
                ?>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
<?php
function cart_count()
{
    try {
        $user_id =   $_SESSION['id'];
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sum = 0;
        $query = $conn->prepare("SELECT `product_id` FROM `cart` WHERE `user_id` = '$user_id'");
        $query->execute();
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($query->fetchAll() as $k => $r) {

            // echo $r[''];
            $sum++;
        }
        echo $sum;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
}
if (isset($_POST['place_order'])) {
    cartToOdrer();
}
function cartToOdrer()
{
    try {
        $user_id =   $_SESSION['id'];
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $conn->prepare("SELECT `product_id`,'quantity' FROM `cart` WHERE `user_id` = '$user_id'");
        $query->execute();
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($query->fetchAll() as $k => $r) {
            $product_id = $r['product_id'];
            $quantity = intval($r['quantity']);
            try {
                $user_id =   $_SESSION['id'];
                $servername = "mysql-server";
                $username = "root";
                $password = "secret";
                $newdb = "mydatabase";
                $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $conn->prepare("INSERT INTO `Orders`(`order_id`, `user_id`, `product_id`, `product_status`, `quantity`) VALUES (null,'$user_id','$product_id' ,'In Process','$quantity')");
                $query->execute();
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $conn = null;
            try {
                $user_id =   $_SESSION['id'];
                $servername = "mysql-server";
                $username = "root";
                $password = "secret";
                $newdb = "mydatabase";
                $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = "DELETE FROM `cart` WHERE `product_id` =  '$product_id'";

        $conn->exec($query);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $conn = null;
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
}
?>