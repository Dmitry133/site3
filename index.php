<?php
session_start();
require_once("pages/classes.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site 3. Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">


    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/jquery_cookie.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <header class="col-12 mr-2">
        </header>
    </div>

    <div class="row">
        <nav class="col-12 mt-4 navbar nav-fill navbar-light w-100 rounded">
            <?php include_once ("pages/menu.php"); ?>
        </nav>
    </div>

    <div class="row">
        <section class="col-12 my-5">
            <?php
            if (isset($_GET["page"])) {
                $page = $_GET["page"];
                if ($page === '1') include_once("pages/catalog.php");
                if ($page === '2') include_once ("pages/cart.php");
                if ($page === '3') include_once ("pages/registration.php");
                if ($page === '4') include_once ("pages/admin.php");
                if ($page === '5') include_once ("pages/login.php");
            }
            ?>
        </section>
    </div>

    <footer class=" row lead text-center bg-light justify-content-center rounded">Step Academy by Dmitry &copy; 2020</footer>

</div>
</body>
</html>
