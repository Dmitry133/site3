

<ul class="nav nav-pills justify-content-around w-100" role="tablist" >
    <li class="nav-item">
        <a href="index.php?page=1" class="nav-link <?php echo ($_GET['page']==='1')?"active":""?> " role="tab" >Catalog</a>
    </li>
    <li class="nav-item">
        <a href="index.php?page=2"  class="nav-link <?php echo ($_GET['page']==='2')?"active":""?> " role="tab">Cart</a>
    </li>
    <li class="nav-item">
        <a href="index.php?page=3"  class="nav-link <?php echo ($_GET['page']==='3')?"active":""?> " role="tab">Registration</a>
    </li>
    <li class="nav-item">
        <a href="index.php?page=4"   class="nav-link <?php echo ($_GET['page']==='4')?"active":""?> " role="tab">Admin Forms</a>
    </li>
    <li class="nav-item">
        <a href="index.php?page=5"   class="nav-link <?php echo ($_GET['page']==='5')?"active":""?> " role="tab">Login</a>
    </li>
</ul>