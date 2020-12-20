<?php
session_start();
require_once("classes.php");
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
    <link rel="stylesheet" href="../css/style.css">


    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/jquery_cookie.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <header class="col-12 mr-2">
<!--            <div class="row mt-5">-->
<!--                <ul class="nav nav-pills justify-content-around w-100" role="tablist" >-->
<!--                    <li class="nav-item">-->
<!--                        <a href="../index.php?page=1" class="nav-link --><?php //echo ($_GET['page']==='1')?"active":""?><!-- " role="tab" >Catalog</a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="../index.php?page=2"  class="nav-link --><?php //echo ($_GET['page']==='2')?"active":""?><!-- " role="tab">Cart</a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="../index.php?page=3"  class="nav-link --><?php //echo ($_GET['page']==='3')?"active":""?><!-- " role="tab">Registration</a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="../index.php?page=4"   class="nav-link --><?php //echo ($_GET['page']==='4')?"active":""?><!-- " role="tab">Admin Forms</a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="../index.php?page=5"   class="nav-link --><?php //echo ($_GET['page']==='5')?"active":""?><!-- " role="tab">Login</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
        </header>
    </div>
        <div class="row">
            <nav class="col-12 mt-4 navbar nav-fill navbar-light w-100 rounded">
                <?php include_once ("menu.php"); ?>
            </nav>
        </div>
     <div class="mt-5">
      <?php
      echo "<div id='message'></div>";
      $itemid = $_GET['name'];
      $items = Item::fullItem($itemid);
      foreach ($items as $item) {
          $item->drawFullItem();
      }
      ?>
     </div>
    </div>

    <footer class="mt-5 row lead text-center bg-light justify-content-center rounded">Step Academy by Dmitry &copy; 2020</footer>

</div>
<script>
    function createCookie(ruser, id) {
        $.cookie(ruser,id,{expires:2,path:'/'});

        let tekst = $('<div id="message-success"><p>Товар добавлен!</p></div>'),
            linc = $('#message');
        linc.html(tekst).fadeIn();
        setTimeout(function() {linc.fadeOut();}, 2000);

    }
</script>

</body>
</html>
