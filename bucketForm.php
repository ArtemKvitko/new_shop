<form name='retProd' method='post'>
    <?php

    if (isset($_POST['retProd'])) {

        $rres = $_SESSION['user']->returnAll($_POST['retProd']);
        if ($rres > 0) {
            echo '<script> alert(" You succesfuly canceled your order!")</script>';
            header('Refresh: 0; url=index.php?page=bucket');
        } else {
            echo '<script> alert(" Something is wrong! Please relogin")</script>';
            header('Refresh: 0; url=index.php?page=logOut');
        }
    } else if (isset($_POST['confirmOrder'])) {

        $msg=$_SESSION['user']->confirmPurchase($_POST['confirmOrder']);
    if ($msg) {
        echo $msg;

    } else {
        echo '<script> alert(" You succesfuly confirmed your order!")</script>';
        header('Refresh: 0; url=index.php?page=bucket');}
    }


    if (!empty($_SESSION['bucket'])) {
        $buyed = new Products();
        foreach ($_SESSION['bucket'] as $itm) {
            $item = $buyed->showProduct($itm['product_id'], false);


            echo "<div id='showName'> <img src='img/icon/" . $item->brand . ".png' height='24px' id='justLeft'>

                     <h2> " . $item->brand . " - </h2> <h2> " . $item->name . " </h2> </div><br>
                     <div id='bucketItems'>
                     <div id='justLeft' ><img src='img/" . $item->pic . "' id='imgitem' ></div>

                      <div id='specyfication'> <h3>";


            $buyed->printSpec($item->specyfication);


            echo '</h3></div><br/>You`ve purchased <b id="err">' . $itm['purchase_count'] . '</b> items <br>';
            echo '<h2>Total price:  <b id="err">' . $itm['purchase_count'] * $item->price . '</b> $ </h2>  <br>';
            echo '<button class="orderConfirm" type="submit" name="confirmOrder" value="' . $itm['id'] . '"> Confirm order </button>';
            echo '<button class="orderCancel" type="submit" name="retProd" value="' . $itm['id'] . '"> Cancel order </button>';

            echo "</div>";

        }


    } else {
        echo '<center><h1> Nothing is added to cart yet </h1></center>';
    }
    ?>
</form>