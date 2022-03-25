<?php include 'post.php';
session_start();
?>
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
    <title>Shop Homepage</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="styles.css" rel="stylesheet" />

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!"><?php name(); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item mt-1 mx-2">
                        <span for="exampleFormControlSelect1">Product Category</span>
                        <select class="p-1" id="filter" onchange="filter()" id="exampleFormControlSelect1">
                            <option selected disabled>Filter</option>
                            <option>All</option>
                            <option>Electronics</option>
                            <option>Guns</option>
                            <option>Toys</option>
                            <option>Miscellaneous</option>
                        </select>
                    </li>
                </ul>
                <form action="" method="POST" class="d-flex">
                    <a class="btn btn-outline-dark" href="cart.php">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"></span>
                    </a>
                    <button name="logout" type="submit" class="btn btn-outline-dark mx-4 ">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark">
        <div class="container px-4 px-lg-5 my-5">
            <img src="image/hello.jpeg" width="100%" height="400">
       
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <form>
            <div class="container px-4 px-lg-5 mt-5" id="main">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 ">
                    <?php display_products(); ?>
                </div>
            </div>
        </form action="post.php" method="POST">
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">COPYRIGHT &copy; CEDCOSS TECHNOLOGIES</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
</body>

</html>
<script>

    function filter() {
        $.ajax({
            url: 'post.php',
            datatype: 'json',
            type: 'post',
            data: {
                action: 'filter',
                filter: document.getElementById('filter').value,

            },
            success: function(data) {
                console.log(data);
                location.reload();
            }
        })
    }

    $("#main").on("click", ".add-to-cart", function(event) {
        event.preventDefault();
        add2Cart($(this).data("id"), $(this).data("name"), $(this).data("image"), $(this).data("price"), $(this).data("category"));
    });

    function add2Cart(id, name, image, price, category) {
        $.ajax({
            url: 'post.php',
            datatype: 'json',
            type: 'post',
            data: {
                action: 'addtocart',
                id: id,
                name: name,
                image: image,
                price: price,
                category: category

            },
            success: function(data) {
                console.log(data);
                if(data == 0){
                    alert('Please Login');
                }
               
            }
        })
    }
</script>
