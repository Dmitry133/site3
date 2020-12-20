<?php
class Tools {
    static function connect ($host="localhost:3306", $user='root', $pass='123456', $dbname='shop') {
        //PDO (PHP data object) - механизм взаимодействия с СУБД
        //PDO - позволяет облегчить рутинные задачи при выполнении запросов и содержит защитные механизмы при работе с СУБД

        // определим DSN(Data source name) - сведения для подключения к БД
        $cs = "mysql:host=$host;dbname=$dbname;charset=utf8";

        //массив опций для создания PDO
        $options = [
            PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
        ];
        try {
            $pdo = new PDO($cs, $user, $pass, $options);
            return  $pdo;
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }
}

class Customer {
    public $id;
    public $login;
    public $pass;
    public $roleid;
    public $discount;
    public $total;
    public $imagepath;

    function __construct($login, $pass, $imagepath, $id =0) {
        $this ->login = trim($login);
        $this ->pass = trim($pass);
        $this ->imagepath = $imagepath;
        $this ->id = $id;

        $this-> total = 0;
        $this->discount = 0;
        $this->roleid = 2;
    }

    function register() {
        if($this->login === '' || $this->pass === '') {
            echo "<h3 class='text-danger'>Заполните все поля</h3>";
            return false;
        }
        if(strlen($this->login) < 3 || strlen($this->login) > 32 || strlen($this->pass) < 3 || strlen($this->pass) > 128 ) {
            echo "<h3 class='text-danger'>Не корректная длина полей</h3>";
            return false;
        }

        $this->intoDb();
        return true;
    }

    static function login ($login,$pass){
        if (strlen($login)<3||strlen($login)>32||strlen($pass)>64){
            echo "<h4 class='text-danger'>Некорректная длинна полей!!</h4>";
            return false;
        }

        $pdo=Tools::connect();
            $ps = $pdo->query("SELECT * FROM customers where login='$login' and pass='$pass'");
        while($row = $ps->fetch()) {
            if ($row['login'] == $login && $pass == $row['pass']) {
                $_SESSION['ruser'] = $login;
                echo '<script>window.location=document.URL</script>';

                if ($row['roleid'] == 1) {
                    $_SESSION['radmin'] = $login;
                    echo '<script>window.location=document.URL</script>';
                }
            }


        }  echo "<h3 class='text-danger'>Пользователь не найден!</h3>";
            return false;

    }





    function intoDb() {
        try {
            $pdo = Tools::connect();
            //подготовим запрос на доболвение пользователя
            $ps = $pdo->prepare("INSERT INTO customers(login, pass, roleid, discount, total, imagepath) VALUES(:login, :pass, :roleid, :discount, :total, :imagepath)");

            //разименовывание объекта this и преобразование к массиву
            $ar =(array)$this; // $ar = [:id, :login, :pass, :roleid, :discount, :total, :imagepath]
            array_shift($ar); //удаляем первый элемент массива id
            // ar =  :login, :pass, :roleid, :discount, :total, :imagepath]
            $ps->execute($ar);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}


class Item {
    public $id;
    public $itemname;
    public $catid;
    public $pricein;
    public $pricesale;
    public $info;
    public $rate;
    public $imagepath;
    public $action;
    public $quantity;

    function __construct($itemname, $catid, $pricein, $pricesale, $info, $imagepath,  $quantity ,$rate=0, $action=0, $id=0) {
        $this->id = $id;
        $this->quantity=$quantity;
        $this->action =$action;
        $this->rate = $rate;
        $this->catid=$catid;
        $this->pricein=$pricein;
        $this->pricesale=$pricesale;
        $this->info=$info;
        $this->itemname=$itemname;
        $this->imagepath=$imagepath;

    }

    function intoDb() {
        try {
            $pdo = Tools::connect();
            $ps =$pdo->prepare("INSERT INTO items(itemname, catid, pricein, pricesale, info, imagepath,quantity, rate, action ) VALUES(:itemname, :catid, :pricein, :pricesale, :info, :imagepath , :quantity, :rate, :action)");
            $ar =(array)$this;
            array_shift($ar);
            $ps->execute($ar);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    static function fromDb($id) {
        try {
            $pdo = Tools::connect();
            $ps = $pdo->prepare("SELECT * FROM items WHERE id=?");
            $ps->execute([$id]);
            $row= $ps ->fetch();
            $item = new Item($row['itemname'], $row['catid'], $row['pricein'], $row['pricesale'], $row['info'], $row['imagepath'],$row['quantity'], $row['rate'], $row['action'],  $row['id']);
            return $item;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    //метод формирования твоаров
    static function getItems($catid = 0) {
        try {
            $pdo = Tools::connect();//если категория не выбарна = 0 то выбираем все товары
            if ($catid == 0) {
                $ps = $pdo->query("SELECT * FROM items");
            } else {
                $ps = $pdo->prepare("SELECT * FROM items WHERE catid=?");
                $ps->execute([$catid]);
            }

            while ($row = $ps->fetch()) {
                $item = new Item($row['itemname'], $row['catid'], $row['pricein'], $row['pricesale'], $row['info'], $row['imagepath'],$row['quantity'], $row['rate'], $row['action'],  $row['id']);

                //создадим массив экземпляров объектов классов Item
                $items[] = $item;
            }
            return $items;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



   static function fullItem($id) {

      try {
          $pdo = Tools::connect();


          $ps = $pdo->query("SELECT * FROM items WHERE id='$id'");

          while ($row = $ps->fetch()) {
              $item = new Item($row['itemname'], $row['catid'], $row['pricein'], $row['pricesale'], $row['info'], $row['imagepath'],$row['quantity'], $row['rate'], $row['action'],  $row['id']);

              //создадим массив экземпляров объектов классов Item
              $items[] = $item;

          }

          return $items;



      } catch (PDOException $e) {
          echo $e->getMessage();
          return false;
      }
    }

    function drawFullItem() {
        echo '<div class="iteminfo-card">';
        //шапка товара
        echo '<div class="mt-3 iteminfo-card__header">';
        echo "<span class='iteminfo-card__name h2'>$this->itemname</span>";
        echo "<span class='m-2 float-left'>Осталось:$this->quantity</span>";
        echo "<span class='m-2 float-right'>$this->rate</span>";
        echo '</div>';

        //описание
        echo '<div class="mt-1 text-center item-card__info">';
        echo "<span class='lead item-card__infotext'>$this->info</span>";
        echo '</div>';

        // изображение товара
        echo '<div class="mt-1 itemifo-card__img">';
        echo "<img src='../{$this->imagepath}' alt='image' class='img-fluid ml-5'>";
        echo '</div>';


        //цена товара
        echo '<div class="text-center itemifo-card__price">';
        echo "<span>$this->pricesale RUB</span>";
        echo '</div>';


        echo '<div class="mt-1 text-center iteminfo-card__button">';
        // $ruser='';
        $ruser = 'cart_'.$this->id;
        echo "<button class='btn btn-primary btn-lg btn-block' id='sales' onclick=createCookie('".$ruser."','". $this->id."')>Add to cart</button>";

        echo '</div>';

    }

    //метод отрисовки твоаров
    function drawItem() {
            echo '<div class="col-sm-6 col-md-3 item-card m-2 mt-4">';

                     //шапка товара
                echo '<div class="mt-3 item-card__header">';
                    echo "<a href='pages/iteminfo.php?name={$this->id}' target='_blank' class='ml-2 float-left item-card__name h4'>$this->itemname</a>";
                    echo "<span class='mr-2 float-right'>$this->rate</span>";
                    echo "<span class='m-2'>Осталось:$this->quantity</span>";
                echo '</div>';

                    // изображение товара
                    echo '<div class="mt-1 item-card__img">';
                    echo "<img src='{$this->imagepath}' alt='image' class='img-fluid'>";
                    echo '</div>';

                    //цена товара
                    echo '<div class="text-center item-card__price">';
                    echo "<span>$this->pricesale RUB</span>";

                    echo '</div>';

                    //описание
                    echo '<div class="mt-1 text-center item-card__info">';
                    echo "<span class='lead item-card__infotext'>$this->info</span>";
                    echo '</div>';

                    //кнопка добавления в корзину


                    echo '<div class="mt-1 text-center item-card__button">';
                    $ruser = 'cart_'.$this->id;
                     if($this->quantity > 0) {
                      echo "<button class='btn btn-primary btn-lg btn-block' id='sales' name='sendor' type='submit' onclick=createCookie('".$ruser."','". $this->id."')>Add to cart</button>";
                    } else {
                        echo "<p class='text-warning'>Sorry,Out of stock</p>";
                    }
                    echo '</div>';

            echo '</div>';


    }

    function drawItemAtCart() {

        echo '<div class="row m-2 item-cart">';
            echo "<span class='col-1'>$this->id</span>";
            echo "<img src='{$this->imagepath}' alt='image' class='col-2 img-fluid item-cart__img'>";
            echo "<span class='col-2 item-cart__name'>$this->itemname</span>";
            echo "<p>Осталось:$this->quantity</p>";
            echo "<input name='quantity[]'  id='quantity' placeholder='Сколько шт.' class='item-cart__quantity'>";
            echo "<span class='col-2 item-cart__price'>$this->pricesale RUB</span>";
            $ruser = 'cart_'.$this->id;
            echo "<button class='btn btn-danger item-cart__btn' onclick=eraseCookie('".$ruser."')>Delete</button>";
        echo '</div>';
    }


    function sale($quan) {
        try {
            $pdo=Tools::connect();
            $newQuantity = $this->quantity - $quan;
            $updQuan="UPDATE items SET quantity=$newQuantity WHERE id=?";
            $ps=$pdo->prepare($updQuan);
            $ps->execute([$this->id]);

            $pdo = Tools::connect();
            $upd = "UPDATE customers SET total=total +? WHERE login=?";
            $ps = $pdo->prepare($upd);
            $login = $_SESSION['ruser'];
            $ps->execute([$this->pricesale, $login]);


            //добавить логи для покупок на сайте
            $ins = "INSERT INTO sales(customername, itemname, pricein, pricesale, datesale) VALUES (?,?,?,?,?)";
            $ps = $pdo->prepare($ins);
            $ps->execute([$login, $this->itemname, $this->pricein, $this->pricesale, @date("Y/m/d H:i:s")]);
            return $this->id;



        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    static function SMTP($id_result) {
        require_once ("PHPMailer/PHPMailerAutoload.php");
        require_once ("private/private_data.php");
        $mail = new PHPMailer;
        // настройка протокола(протокол передачи данных почтовых сообщений)
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();

        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 25;
        $mail->Username = MAIL;
        $mail->Password = PASS;

        //от кого
        $mail->setFrom(MAIL, 'Shop by Dmitry');

        //кому шлем!
        $mail->addAddress('dimalog92@gmail.com', 'From Shop by Dmitry');

        //тема письма

        $mail->Subject = 'Новый заказ';

        //тело письма

        $body = "<table cellpadding='0' cellspacing='0' border='2' width='800' style='background-color: wheat!important;'>";
        $arr_items = [];
        $i = 0;
        foreach ($id_result as $id) {
            $item = self::fromDb($id);
            array_push($arr_items, $item->itemname,$item->pricesale, $item->info); // для csv файла
            $mail->addEmbeddedImage($item->imagepath, 'item'.++$i);
            $body .="<tr>
                        <th>$item->itemname</th>   
                        <td>$item->pricesale</td>
                        <td>$item->info</td>
                        <td><img src='cid:item{$i}' alt='item' ></td>
                     </tr>";
        }
        $body .= '</table>';

        $mail->msgHTML($body);
        try {
            $mail->send();
        } catch (phpmailerException $e) {
            echo $e->getMessage();
        }
        // вызов и создание csv файла

        try {
            $csv = new CSV('private/excel_file.csv');
            $csv->setCSV($arr_items);
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

class CSV {
    private $csv_file = null;

    public function __construct($csv_file) {
        $this->csv_file = $csv_file;
    }

    function setCSV($arr_item) {

        $file = fopen($this->csv_file,'a+');
        fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF) );
        foreach ($arr_item as $item) {

            fputcsv($file,[$item]);
        }
        fclose($file);
    }
}

class Category {
    public $id;
    public $category;

    function __construct($category, $id=0)
    {
        $this->id = $id;
        $this->category = $category;
    }

    function intoCategory() {
        try {
            $pdo = Tools::connect();
            $ps =$pdo->prepare("INSERT INTO categories(category) VALUES (:category)");
            $ar =(array)$this;
            array_shift($ar);
            $ps->execute($ar);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}




