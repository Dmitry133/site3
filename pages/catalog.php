<h3>Catalog page</h3>

<form action="index.php?page=1" method="post">
    <div>
        <select name="catid" class="mb-3" onchange="getItemsCat(this.value)">
            <option value="0">Select category</option>
            <?php
            $pdo=Tools::connect();
            $ps=$pdo->prepare("SELECT * FROM categories");
            $ps->execute();
            //Добавляем все категории в option
            while($row=$ps->fetch()) {
                echo "<option value=".$row['id'].">".$row['category']."</option>";
            }
            ?>
        </select>
    </div>

<?php
echo "<div id='message'></div>";
echo '<div id="result" class="row d-flex justify-content-around">';
    $items = Item::getItems();
    foreach ($items as $item) {
        $item->drawItem();
    }
echo '</div>';

    ?>
</form>
<script>
    function getItemsCat(cat) {
        if(window.XMLHttpRequest) {
            ao = new XMLHttpRequest();
        } else {
            ao = new ActiveXObject('Microsoft.XMLHTTP');
        }
        ao.onreadystatechange = function () {
            if(ao.readyState === 4 && ao.status === 200) {
                document.getElementById('result').innerHTML = ao.responseText;
            }
        }
        ao.open('POST', 'pages/lists.php', true);
        ao.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ao.send("cat="+cat);
    }


    function createCookie(ruser, id) {
        $.cookie(ruser,id,{expires:2,path:'/'});


            let tekst = $('<div id="message-success"><p>Товар добавлен!</p></div>'),
                linc = $('#message');
            linc.html(tekst).fadeIn();
            setTimeout(function() {linc.fadeOut();}, 2000);

    }
</script>

