<?php include 'post.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">
                <h3>ADMIN PANEL</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">DASHBOARD</a></li>
                    <li class="nav-item"><a class="nav-link"  href="admin_panel.php">USERS</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="products.php">PRODUCTS</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">ORDERS</a></li>

                </ul>
                <form class="d-flex">
                    <input type="text" class="px-2" name="search_box" placeholder="Search here...">
                    <button class="btn btn-outline-dark mx-2" name="search" type="submit">search</button>
                    <a style="font-size: small;" href="addproduct.php" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Add Product
                   </a>



                </form>
            </div>
        </div>
    </nav>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-1">

            </div>
            <div class="col-11">
                <?php display_product_table(); ?>
            </div>
        </div>
    </div>
</body>
</html>