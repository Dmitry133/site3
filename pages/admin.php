<?php


?>
<h3>Admin Forms</h3>
<?php
if (!isset($_POST['addbtn'])) {

?>
    <form action="index.php?page=4" method="post" enctype="multipart/form-data">
        <input type="text" name="category" placeholder="Новая категория" class="mr-2" id="newcategory">
        <input type="submit" name="addcategory" value="Добавить" class="btn btn-sm btn-info mr-2">
        <?php
            if (isset($_POST['addcategory'])) {
                $pdo = Tools::connect();
                $category = new Category(trim($_POST['category']));
                $category->intoCategory();
            }

        ?>
        <div class="form-group mt-3">
            <label for="category">Category:(вот мы смотрим созданые категории дз32! а сверху добавляем!в теге option встроенный поиск уже есть!)
                <select name="catid" id="category">
                    <?php
                        $pdo = Tools::connect();
                        $ps = $pdo->query("SELECT * FROM categories");//выполнить запрос(вместо препаре и экзекют)

                        while ($row = $ps->fetch()) {
                            echo "<option value='{$row['id']}'>{$row['category']}</option>";
                        }

                    ?>
                </select>
            </label>
        </div>


        <hr>
        <div class="form-group">
            <label for="">Name:
                <input type="text" name="name" id="name">
            </label>
        </div>

        <div class="form-group">
            <p>Incoming price and sale price:</p>
            <div>
              <label for="">Pricein:
                <input type="number" name="pricein" id="pricein">
              </label>
                <label for="">Pricesale:
                    <input type="number" name="pricesale" id="pricesale">
                </label>
                <label for="">Количество поступило:
                    <input type="number" name="quantity" id="quantity">
                </label>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label for="">Info
                <textarea type="text" name="info" id="info" cols="30" rows="2"></textarea>
            </label>
        </div>
        <hr>
        <div class="form-group">
            <label for="">Images
                <input type="file" name="imagepath" id="imagepath" accept="image/*">
            </label>
        </div>

        <input type="submit" class="btn btn-primary" name="addbtn" value="Add good">
    </form>
<?php
} else {
    if(is_uploaded_file($_FILES['imagepath']['tmp_name'])) {
    $path = "images/goods/".$_FILES['imagepath']['name'];
    move_uploaded_file($_FILES['imagepath']['tmp_name'], $path);
    }

    $item = new Item(trim($_POST['name']),$_POST['catid'], $_POST['pricein'],$_POST['pricesale'],$_POST['info'], $path, $_POST['quantity']);
    $item->intoDb();
}




