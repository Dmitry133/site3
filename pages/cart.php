<h3>Cart</h3>
<?php
echo '<form action="index.php?page=2" method="post">';
$total = 0;
foreach ($_COOKIE as $k => $v) {
    if (substr($k, 0, strpos($k, "_")) === 'cart') {
        $id = substr($k, strpos($k, "_") + 1);
        $item = Item::fromDb($id);
        $total += $item->pricesale;
        $item->drawItemAtCart();
    }
}
echo '<hr>';
echo "<span class='ml-5 text-primary'>Total price:$total RUB</span>";
echo "<button type='submit' class='btn btn-primary btn-lg ml-5' name='suborder' onclick=eraseCookie('cart')>Purchase order</button>";

echo '</form>';
echo "<div id='message'></div>";

// обработчик для оформления заказов
if (isset($_POST['suborder'])) {
    $id_result=[];
    $quan = $_POST['quantity'];
    foreach ($quan as $key => $value){
        $quan = $quan[$key];


    foreach ($_COOKIE as $k => $v) {
        if (substr($k, 0, strpos($k, "_")) === 'cart') {
            $id = substr($k, strpos($k, "_") + 1);
            $item = Item::fromDb($id);
            array_push($id_result, $item->sale($quan));
        }}}

    // Item::SMTP($id_result);
}
?>

<script>
    function eraseCookie(ruser) {
        $.removeCookie(ruser, {path: '/'});


        let tekst = $('<div id="message-success"><p>Заказ отправлен!</p></div>'),
            linc = $('#message');
        linc.html(tekst).fadeIn();
        setTimeout(function() {linc.fadeOut();}, 2000);
    }
</script>
