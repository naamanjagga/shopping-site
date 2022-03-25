<?php
// session_start();

$servername = "mysql-server";
$username = "root";
$password = "secret";
$newdb = "mydatabase";


if (isset($_POST['btn1'])) {
    $sign_name = $_POST['name'];
    $sign_username = $_POST['username'];
    $sign_email = $_POST['email'];
    $sign_password = md5($_POST['password']);
    $sign_confirm_password = md5($_POST['confirm_password']);




    try {
        $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $conn->prepare("SELECT * FROM `Users` WHERE `email` = '$sign_email' ");
        $query->execute();

        $count = $query->rowCount();
        if ($count > 0) {
            echo "<h1>Email Already Exist</h1>";
        } else {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $conn->prepare("INSERT INTO `Users`(`id`, `name`, `username`, `email`, `password`, `User_status`,`User_role`) VALUES (null,'$sign_name','$sign_username','$sign_email','$sign_password','Pending','Customer')");
                $query->execute();

                echo '<h1>Hello ' . $sign_name . ' ..!</h1>';
                echo '<br>';
                echo '<h1>Wait until admin allows you to go ahead<h1><br>';
                echo '<a href="log_in.php" class="btn btn-lg bg-primary">Move to Login Page</a> ';
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
if (isset($_POST['btn2'])) {
    $login_email = $_POST['login_email'];
    $login_password = md5($_POST['login_password']);

    try {
        $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $conn->prepare("SELECT `User_status` FROM `Users` WHERE `email`  =  '$login_email'");
        $query->execute();

        $r = $query->fetch(PDO::FETCH_ASSOC);

        if ($r['User_status'] == "Approve") {

            try {
                $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $conn->prepare("SELECT `id` FROM `Users` WHERE `email` = '$login_email' AND `password` = '$login_password'");
                $query->execute();

                $count = $query->rowCount();
                if ($count > 0) {
                    $r = $query->fetch(PDO::FETCH_ASSOC);

                    $_SESSION['id'] = $r['id'];
                    $_SESSION['name'] = $r['name'];

?>
                    <script>
                        location.href = 'frontend.php';
                    </script>
            <?php

                    exit();
                } else {
                    echo '<h1>Please check your email and Password<h1>';
                }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $conn = null;
        } else {
            echo '<h1>Admin have not approved your account yet</h1>';
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

if (isset($_POST['admin_login'])) {
    // display();
}
if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = "DELETE FROM `Users` WHERE id =  $id";

        $conn->exec($query);
        //display();
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}

if (isset($_POST['change'])) {
    $status = $_POST['change'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = $conn->prepare("SELECT `User_status` FROM `Users` WHERE id =  '$status'");
        $query->execute();

        $r = $query->fetch(PDO::FETCH_ASSOC);

        if ($r['User_status'] == "Pending") {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $query = "UPDATE `Users` SET `User_status`='Approve' WHERE id= $status";

                $conn->exec($query);
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

            $conn = null;
        } else {
            try {
                $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $query = "UPDATE `Users` SET `User_status`='Pending' WHERE id= $status";

                $conn->exec($query);
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

            $conn = null;
        }
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}


function display()
{
    $results_per_page = 4;
    try {
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = $conn->prepare("SELECT * FROM Users ");
        $query->execute();
        $number_of_result = $query->rowCount();
        $number_of_page = ceil($number_of_result / $results_per_page);
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $page_first_result = ($page - 1) * $results_per_page;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $conn->prepare("SELECT *FROM Users LIMIT " . $page_first_result . ',' . $results_per_page);
            $query->execute();
            echo '<form action="" method="POST" ><table ><tr class="border p-3"><th class="border p-3">ID</th><th class="border p-3">NAME</th><th class="border p-3">USERNAME</th><th class="border p-3">PASSWARD</th><th class="border p-3">USER STATUS</th><th class="border p-3">USER ROLE</th><th class="border p-3">CHANGE STATUS</th><th class="border p-3">DELETE</th><th></th></tr>';
            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($query->fetchAll() as $k => $r) {
                echo '<tr class="border p-3"><td class="border p-3">' . $r['id'] . '</td><td class="border p-3">' . $r['name'] . '</td><td class="border p-3">' . $r['email'] . '</td><td class="border p-3">' . $r['password'] . '</td><td class="border p-3">' . $r['User_status'] . '</td><td class="border p-3">' . $r['User_role'] . '</td><td class="border p-3"><button class="bg-dark text-light" name="change" value="' . $r['id'] . '" >change</button></td><td class="border p-3"><button class="bg-danger" name="delete" value="' . $r['id'] . '" >delete</button></td></tr>';
            }
            ?>
            <ul class="pagination mt-3 ">
                <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                    <li class="page-item"><?php echo '<a class="page-link " href = "admin_panel.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                <?php } ?>
            </ul>
            <?php

        } catch (PDOException $e) {
            // echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
    echo "</table></form>";
}
if (isset($_POST['action']) && $_POST['action'] == 'add_product') {
    $p_name = $_POST['p_name'];
    $p_price = intval($_POST['p_price']);
    $p_image = $_FILES['p_image'];
    $p_category = $_POST['p_category'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $conn->prepare("INSERT INTO `Products`(`product_id`, `product_name`, `product_image`, `product_category`, `product_price`) VALUES (null,'$p_name','$p_image','$p_category','$p_price')");
        $query->execute();
        echo "New record created successfully";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
}

if (isset($_POST['action']) && $_POST['action'] == 'addtocart') {
    if (isset($_SESSION['id'])) {
        echo 'value set';
        $id = $_POST['id'];
        $name = $_POST['name'];
        $image = $_POST['image'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        try {
            $user_id = $_SESSION['id'];
            $servername = "mysql-server";
            $username = "root";
            $password = "secret";
            $newdb = "mydatabase";
            $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $conn->prepare("SELECT `quantity`,`product_price` FROM `cart` WHERE `product_id` = '$id' AND `user_id` = '$user_id'");
            $query->execute();
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $count = $query->rowCount();
            $u_price = 0;
            if ($count > 0) {
                $u_price +=  $r['product_price'];
                $u_quantity =  $r['quantity'] + 1;
                try {
                    $servername = "mysql-server";
                    $username = "root";
                    $password = "secret";
                    $newdb = "mydatabase";
                    $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $query = "UPDATE `cart` SET `quantity`='$u_quantity',`product_price` = '$u_price' WHERE `product_id`= $id AND `user_id` = '$user_id'";
                    $conn->exec($query);
                } catch (PDOException $e) {
                    echo $sql . "<br>" . $e->getMessage();
                }

                $conn = null;
            } else {

                try {
                    $user_id =   $_SESSION['id'];
                    $servername = "mysql-server";
                    $username = "root";
                    $password = "secret";
                    $newdb = "mydatabase";
                    $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $array = array($_POST['id'], $_POST['name'], $_POST['image'], $_POST['price']);
                    $query = $conn->prepare("INSERT INTO `cart`(`user_id`,`product_id`, `product_name`, `product_image`, `product_category`, `product_price`, `quantity`) VALUES (  '$user_id','$id','$name','$image','$category','$price',1) ");
                    $query->execute();
                    echo "New record created successfully";
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $conn = null;
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    } else {
        echo 0;
    }
}




if (isset($_POST['action']) && $_POST['action'] == 'filter') {
    $_SESSION['filter']  = $_POST['filter'];
}
function display_products()
{
    $results_per_page = 4;
    try {
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        switch ($_SESSION['filter']) {
            case 'Electronics':
                $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Electronics' ");
                $query->execute();
                $number_of_result = $query->rowCount();
                $number_of_page = ceil($number_of_result / $results_per_page);
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }
                $page_first_result = ($page - 1) * $results_per_page;
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Electronics' LIMIT " . $page_first_result . ',' . $results_per_page);
                    $query->execute();
                    $result = $query->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($query->fetchAll() as $k => $r) {
                        echo ' <div class="col mb-5" >
                    <div class="card h-100">
                    <img class="card-img-top" src="image/' . $r['product_image'] . '" alt="..." width="100" height="200"/>
                    <div class="card-body p-4">
                    <div class="text-center">
                    <h5 class="fw-bolder">' . $r['product_name'] . '</h5>
                    <p>Price: ₹' . $r['product_price'] . '</p>
                    </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div><br>
                    <div class="text-center"><a class="add-to-cart btn btn-outline-dark" data-id=" ' . $r['product_id'] . ' " data-name="' . $r['product_name'] . ' " data-image="' . $r['product_image'] . '" data-category="' . $r['product_category'] . '" >Add To Cart</a></div>
                    </div>
                    </div>
                    </div>';
                    }
            ?>
                    <ul class="pagination mt-3 ">
                        <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                            <li class="page-item"><?php echo '<a class="page-link " href = "frontend.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                        <?php } ?>
                    </ul>
                <?php
                } catch (PDOException $e) {
                    // echo $sql . "<br>" . $e->getMessage();
                }

                $conn = null;
                break;
            case 'Guns':
                $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Guns'");
                $query->execute();
                $number_of_result = $query->rowCount();
                $number_of_page = ceil($number_of_result / $results_per_page);
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }
                $page_first_result = ($page - 1) * $results_per_page;
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Guns' LIMIT " . $page_first_result . ',' . $results_per_page);
                    $query->execute();
                    $result = $query->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($query->fetchAll() as $k => $r) {
                        echo ' <div class="col mb-5" >
                    <div class="card h-100">
                    <img class="card-img-top" src="image/' . $r['product_image'] . '" alt="..." width="100" height="200"/>
                    <div class="card-body p-4">
                    <div class="text-center">
                    <h5 class="fw-bolder">' . $r['product_name'] . '</h5>
                    <p>Price: ₹' . $r['product_price'] . '</p>
                    </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div><br>
                    <div class="text-center"><a class="add-to-cart btn btn-outline-dark" data-id=" ' . $r['product_id'] . ' " data-name="' . $r['product_name'] . ' " data-image="' . $r['product_image'] . '" data-price="' . $r['product_price'] . '" data-category="' . $r['product_category'] . '" >Add To Cart</a></div>
                    </div>
                    </div>
                    </div>';
                    }
                ?>
                    <ul class="pagination mt-3 ">
                        <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                            <li class="page-item"><?php echo '<a class="page-link " href = "frontend.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                        <?php } ?>
                    </ul>
                <?php
                } catch (PDOException $e) {
                    // echo $sql . "<br>" . $e->getMessage();
                }

                $conn = null;
                break;
            case 'Toys':
                $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Toys'");
                $query->execute();
                $number_of_result = $query->rowCount();
                $number_of_page = ceil($number_of_result / $results_per_page);
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }
                $page_first_result = ($page - 1) * $results_per_page;
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Toys' LIMIT " . $page_first_result . ',' . $results_per_page);
                    $query->execute();
                    $result = $query->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($query->fetchAll() as $k => $r) {
                        echo ' <div class="col mb-5" >
                    <div class="card h-100">
                    <img class="card-img-top" src="image/' . $r['product_image'] . '" alt="..." width="100" height="200"/>
                    <div class="card-body p-4">
                    <div class="text-center">
                    <h5 class="fw-bolder">' . $r['product_name'] . '</h5>
                    <p>Price: ₹' . $r['product_price'] . '</p>
                    </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div><br>
                    <div class="text-center"><a class="add-to-cart btn btn-outline-dark" data-id=" ' . $r['product_id'] . ' " data-name="' . $r['product_name'] . ' " data-image="' . $r['product_image'] . '" data-price="' . $r['product_price'] . '" data-category="' . $r['product_category'] . '" >Add To Cart</a></div>
                    </div>
                    </div>
                    </div>';
                    }
                ?>
                    <ul class="pagination mt-3 ">
                        <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                            <li class="page-item"><?php echo '<a class="page-link " href = "frontend.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                        <?php } ?>
                    </ul>
                <?php
                } catch (PDOException $e) {
                    // echo $sql . "<br>" . $e->getMessage();
                }

                $conn = null;
                break;
            case 'Miscellaneous':
                $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Miscellaneous'");
                $query->execute();
                $number_of_result = $query->rowCount();
                $number_of_page = ceil($number_of_result / $results_per_page);
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }
                $page_first_result = ($page - 1) * $results_per_page;
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $query = $conn->prepare("SELECT * FROM `Products` WHERE product_category = 'Miscellaneous' LIMIT " . $page_first_result . ',' . $results_per_page);
                    $query->execute();
                    $result = $query->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($query->fetchAll() as $k => $r) {
                        echo ' <div class="col mb-5" >
                    <div class="card h-100">
                    <img class="card-img-top" src="image/' . $r['product_image'] . '" alt="..." width="100" height="200"/>
                    <div class="card-body p-4">
                    <div class="text-center">
                    <h5 class="fw-bolder">' . $r['product_name'] . '</h5>
                    <p>Price: ₹' . $r['product_price'] . '</p>
                    </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div><br>
                    <div class="text-center"><a class="add-to-cart btn btn-outline-dark" data-id=" ' . $r['product_id'] . ' " data-name="' . $r['product_name'] . ' " data-image="' . $r['product_image'] . '" data-price="' . $r['product_price'] . '" data-category="' . $r['product_category'] . '" >Add To Cart</a></div>
                    </div>
                    </div>
                    </div>';
                    }
                ?>
                    <ul class="pagination mt-3 ">
                        <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                            <li class="page-item"><?php echo '<a class="page-link " href = "frontend.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                        <?php } ?>
                    </ul>
                <?php
                } catch (PDOException $e) {
                    // echo $sql . "<br>" . $e->getMessage();
                }

                $conn = null;
                break;
            case 'All':
                $query = $conn->prepare("SELECT * FROM `Products` ");
                $query->execute();
                $number_of_result = $query->rowCount();
                $number_of_page = ceil($number_of_result / $results_per_page);
                if (!isset($_GET['page'])) {
                    $page = 1;
                } else {
                    $page = $_GET['page'];
                }
                $page_first_result = ($page - 1) * $results_per_page;
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $query = $conn->prepare("SELECT * FROM `Products` LIMIT " . $page_first_result . ',' . $results_per_page);
                    $query->execute();
                    $result = $query->setFetchMode(PDO::FETCH_ASSOC);
                    foreach ($query->fetchAll() as $k => $r) {
                        echo ' <div class="col mb-5" >
                    <div class="card h-100">
                    <img class="card-img-top" src="image/' . $r['product_image'] . '" alt="..." width="100" height="200"/>
                    <div class="card-body p-4">
                    <div class="text-center">
                    <h5 class="fw-bolder">' . $r['product_name'] . '</h5>
                    <p>Price: ₹' . $r['product_price'] . '</p>
                    </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div><br>
                    <div class="text-center"><a class="add-to-cart btn btn-outline-dark" data-id=" ' . $r['product_id'] . ' " data-name="' . $r['product_name'] . ' " data-image="' . $r['product_image'] . '" data-price="' . $r['product_price'] . '" data-category="' . $r['product_category'] . '" >Add To Cart</a></div>
                    </div>
                    </div>
                    </div>';
                    }
                ?>
                    <ul class="pagination mt-3 ">
                        <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                            <li class="page-item"><?php echo '<a class="page-link " href = "frontend.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                        <?php } ?>
                    </ul>
            <?php
                } catch (PDOException $e) {
                    // echo $sql . "<br>" . $e->getMessage();
                }

                $conn = null;
                break;
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
}

function display_orders()
{
    $results_per_page = 4;
    try {
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = $conn->prepare("SELECT * FROM Orders ");
        $query->execute();

        $number_of_result = $query->rowCount();
        $number_of_page = ceil($number_of_result / $results_per_page);
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $page_first_result = ($page - 1) * $results_per_page;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $conn->prepare("SELECT * FROM Orders LIMIT " . $page_first_result . ',' . $results_per_page);
            $query->execute();

            echo '<form action="" method="POST" ><table ><tr class="border p-3"><th class="border p-3">ORDER ID</th><th class="border p-3">USER ID</th><th class="border p-3">PRODUCT ID</th><th class="border p-3">PRODUCT STATUS</th><th class="border p-3">QUANTITY</th><th class="border p-3">CHANGE STATUS</th><th class="border p-3">DELETE</th><th></th></tr>';
            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($query->fetchAll() as $k => $r) {
                echo '<tr class="border p-3"><td class="border p-3">' . $r['order_id'] . '</td><td class="border p-3">' . $r['user_id'] . '</td><td class="border p-3">' . $r['product_id'] . '</td><td class="border p-3">' . $r['product_status'] . '</td><td class="border p-3">' . $r['quantity'] . '</td><td class="border p-3"><button class="bg-dark text-light" name="change" value="" >change</button></td><td class="border p-3"><button class="bg-danger" name="Del" value="' . $r['order_id'] . '" >Remove</button></td></tr>';
            }
            ?>
            <ul class="pagination mt-3 ">
                <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                    <li class="page-item"><?php echo '<a class="page-link " href = "orders.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                <?php } ?>
            </ul>
        <?php
        } catch (PDOException $e) {
            // echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
    echo "</table></form>";
}
function display_dashboard_users()
{
    try {
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = $conn->prepare("SELECT * FROM `Users` LIMIT 3");
        $query->execute();
        echo '<form action="" method="POST" ><table ><tr class="border p-3"><th class="border p-3">ID</th><th class="border p-3">NAME</th><th class="border p-3">USERNAME</th><th class="border p-3">PASSWARD</th><th class="border p-3">USER STATUS</th><th class="border p-3">USER ROLE</th><th class="border p-3">CHANGE STATUS</th><th class="border p-3">DELETE</th><th></th></tr>';
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($query->fetchAll() as $k => $r) {
            echo '<tr class="border p-3"><td class="border p-3">' . $r['id'] . '</td><td class="border p-3">' . $r['name'] . '</td><td class="border p-3">' . $r['email'] . '</td><td class="border p-3">' . $r['password'] . '</td><td class="border p-3">' . $r['User_status'] . '</td><td class="border p-3">' . $r['User_role'] . '</td><td class="border p-3"><button class="bg-dark text-light" name="change" value="' . $r['id'] . '" >change</button></td><td class="border p-3"><button class="bg-danger" name="delete" value="' . $r['id'] . '" >delete</button></td></tr>';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
    echo "</table></form>";
}
function display_dashboard_products()
{
    try {
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = $conn->prepare("SELECT * FROM `Products` LIMIT 3");
        $query->execute();
        echo '<form action="" method="POST" ><table ><tr class="border p-3"><tr class="border p-3"><th class="border p-3">PRODUCT ID</th><th class="border p-3">PRODUCT NAME</th><th class="border p-3">PRODUCT IMAGE</th><th class="border p-3">CATEGORY</th><th class="border p-3">PRICE</th><th class="border p-3">EDIT</th><th class="border p-3">REMOVE</th><th></th></tr>';
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($query->fetchAll() as $k => $r) {
            echo '<tr class="border p-3"><td class="border p-3">' . $r['product_id'] . '</td><td class="border p-3">' . $r['product_name'] . '</td><td class="border p-3">' . $r['product_image'] . '</td><td class="border p-3">' . $r['product_category'] . '</td><td class="border p-3">' . $r['product_price'] . '</td><td class="border p-3"><button class="bg-dark text-light" name="edit" value="' . $r['product_id'] . '" >change</button></td><td class="border p-3"><button class="bg-danger" name="del" value="' . $r['product_id'] . '" >delete</button></td></tr>';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
    echo "</table></form>";
}
function display_dashboard_orders()
{
    try {
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = $conn->prepare("SELECT * FROM `Orders` LIMIT 3");
        $query->execute();
        echo '<form action="" method="POST" ><table ><tr class="border p-3"><th class="border p-3">ORDER ID</th><th class="border p-3">USER ID</th><th class="border p-3">PRODUCT ID</th><th class="border p-3">PRODUCT STATUS</th><th class="border p-3">QUANTITY</th><th class="border p-3">CHANGE STATUS</th><th class="border p-3">DELETE</th><th></th></tr>';
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($query->fetchAll() as $k => $r) {
            echo '<tr class="border p-3"><td class="border p-3">' . $r['order_id'] . '</td><td class="border p-3">' . $r['user_id'] . '</td><td class="border p-3">' . $r['product_id'] . '</td><td class="border p-3">' . $r['product_status'] . '</td><td class="border p-3">' . $r['quantity'] . '</td><td class="border p-3"><button class="bg-dark text-light" name="change" value="" >change</button></td><td class="border p-3"><button class="bg-danger" name="Del" value="' . $r['order_id'] . '" >Remove</button></td></tr>';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
    echo "</table></form>";
}
function display_product_table()
{
    $results_per_page = 4;
    try {
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = $conn->prepare("SELECT * FROM Products ");
        $query->execute();

        $number_of_result = $query->rowCount();
        $number_of_page = ceil($number_of_result / $results_per_page);
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        $page_first_result = ($page - 1) * $results_per_page;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $conn->prepare("SELECT * FROM Products LIMIT " . $page_first_result . ',' . $results_per_page);
            $query->execute();
            echo '<form action="" method="POST" ><table ><tr class="border p-3"><tr class="border p-3"><th class="border p-3">PRODUCT ID</th><th class="border p-3">PRODUCT NAME</th><th class="border p-3">PRODUCT IMAGE</th><th class="border p-3">CATEGORY</th><th class="border p-3">PRICE</th><th class="border p-3">EDIT</th><th class="border p-3">REMOVE</th><th></th></tr>';
            $result = $query->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($query->fetchAll() as $k => $r) {
                echo '<tr class="border p-3"><td class="border p-3">' . $r['product_id'] . '</td><td class="border p-3">' . $r['product_name'] . '</td><td class="border p-3">' . $r['product_image'] . '</td><td class="border p-3">' . $r['product_category'] . '</td><td class="border p-3">' . $r['product_price'] . '</td><td class="border p-3"><button class="bg-dark text-light btn btn-lg" name="edit" value="' . $r['product_id'] . '" >change</button></td><td class="border p-3"><button class="bg-danger btn btn-lg" name="del" value="' . $r['product_id'] . '" >delete</button></td></tr>';
            }
        ?>
            <ul class="pagination mt-3 ">
                <?php for ($page = 1; $page <= $number_of_page; $page++) {  ?>
                    <li class="page-item"><?php echo '<a class="page-link " href = "products.php?page=' . $page . '">' . $page . ' </a>'; ?></li>
                <?php } ?>
            </ul>
    <?php
        } catch (PDOException $e) {
            // echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
    echo "</table></form>";
}
if (isset($_POST['del'])) {
    $id = $_POST['del'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = "DELETE FROM `Products` WHERE `product_id` =  '$id'";

        $conn->exec($query);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
if (isset($_post['edit'])) {
}
function display_cart()
{
    try {
        $user_id =   $_SESSION['id'];
        $servername = "mysql-server";
        $username = "root";
        $password = "secret";
        $newdb = "mydatabase";
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = $conn->prepare("SELECT * FROM cart WHERE `user_id` = ' $user_id' ");
        $query->execute();


        echo '<form action="" method="POST" ><table ><tr class="border p-3"><th class="border p-3">PRODUCT ID</th><th class="border p-3">PRODUCT NAME</th><th class="border p-3">PRODUCT IMAGE</th><th class="border p-3">CATEGORY</th><th class="border p-3">PRICE</th><th class="border p-3">QUANTITY</th><th class="border p-3">BUY NOW</th><th class="border p-3">REMOVE</th><th></th></tr>';
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($query->fetchAll() as $k => $r) {
            echo '<tr class="border p-3"><td class="border p-3">' . $r['product_id'] . '</td><td class="border p-3">' . $r['product_name'] . '</td><td class="border p-3">' . $r['product_image'] . '</td><td class="border p-3">' . $r['product_category'] . '</td><td class="border p-3">' . $r['product_price'] . '</td><td class="border p-3">' . $r['quantity'] . '</td><td class="border p-3"><button class="bg-dark text-light" name="change" value="' . $r['product_id'] . '" >BUY NOW</button></td><td class="border p-3"><button class="bg-danger" name="remove" value="' . $r['product_id'] . '" >X</button></td></tr>';
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
    echo "</table></form>";
}
function total_price()
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
        $query = $conn->prepare("SELECT `product_price` FROM `cart` WHERE `user_id` = '$user_id'");
        $query->execute();
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($query->fetchAll() as $k => $r) {

            // echo $r[''];
            $sum += $r['product_price'];
        }
        echo '<h4>TOTAL PRICE:  ₹' . $sum . '</h4>';
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $conn = null;
}
if (isset($_POST['remove'])) {
    $id = $_POST['remove'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = "DELETE FROM `cart` WHERE `product_id` =  '$id'";

        $conn->exec($query);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
if (isset($_POST['Del'])) {
    $id = $_POST['Del'];
    try {
        $conn = new PDO("mysql:host=$servername;dbname=mydatabase", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $query = "DELETE FROM Orders WHERE order_id =  '$id'";

        $conn->exec($query);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
if (isset($_POST['logout'])) {
    unset($_SESSION['id']);
    // session_destroy();
    ?>
    <script>
        location.href = 'log_in.php';
    </script>
<?php
}
function name()
{
    echo $_SESSION['name'];
}
if (isset($_POST['edit'])) {
    $_SESSION['row'] = $_POST['edit'];
?>
    <script>
        location.href = 'update_product.php';
    </script>
<?php
}
if (isset($_POST['action']) && $_POST['action'] == 'update_product') {
    $u_id = $_POST['u_id'];
    $u_name = $_POST['u_name'];
    $u_price = intval($_POST['u_price']);
    $u_image = $_POST['u_image'];
    $u_category = $_POST['u_category'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$newdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
        $query = "UPDATE `Products` SET `product_name`= '$u_name',`product_image`= '$u_image',`product_category`=   '$u_category',`product_price`= '$u_price' WHERE `product_id`= '$u_id'";

                $conn->exec($query);
        echo "Record updated successfully";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
}

?>