<?php
if (isset($_SESSION['ruser'])){
    echo'<form action="index.php';
    if(isset($_GET['page']))echo "?page=".$_GET['page'];
    echo '" class="input-group" method="post">';
    echo "<h4> Hello " .$_SESSION['ruser'] ."</h4>";
    $login=$_SESSION['ruser'];
    $pdo=Tools::connect();
    $ps = $pdo->query("SELECT total FROM customers where login='$login'");
    while($row = $ps->fetch()) {
        $rt = $row['total'];
        echo "<h3 class='ml-3 text-warning'>Всего купленно на : $rt RUB</h3>";

    }
    echo '<input type="submit" name="exit" value="Выйти" class="btn btn-danger ml-4">';
    echo '</form>';

    if (isset($_POST['exit'])){
        unset($_SESSION['ruser']);
        unset($_SESSION['radmin']);
        echo '<script> window.location.reload();</script>';
    }

}else{
    echo'<form action="index.php';
    if(isset($_GET['page']))echo "?page=".$_GET['page'];
    echo '" class="input-group" method="post">';
    echo '<input type="text" name="login" placeholder="login">';
    echo '<input type="password" name="pass" placeholder="password" class="ml-3">';
    echo '<input type="submit" name="auth" value="Войти" class="btn btn-success ml-3">';
    echo'</form>';

    if (isset($_POST['auth'])AND $_POST['pass']!==''AND $_POST['login']!==''){
        $log=Customer::login($_POST['login'],$_POST['pass']);

    }
    if (isset($_POST['auth'])AND $_POST['pass']=='' || $_POST['login']==''){
       echo "<h3 class='text-danger'>Заполните все поля!</h3>";

    }

}