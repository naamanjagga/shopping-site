<?php include 'post.php' ?>
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
    <?php display_cart(); ?>
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-md-6">
                
                <form action="checkout.php" method="POST">
                <a class="btn btn-lg bg-dark text-light" href="frontend.php">Countinue Shopping</a>
                    <button class="btn btn-lg bg-dark text-light" name="buyall" type="submit">BUY ALL</button>
                </form>
            </div>
            <div class="col-md-6">
                <?php total_price(); ?>
            </div>
        </div>
    </div>
</body>

</html>