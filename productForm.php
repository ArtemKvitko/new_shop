<?php
if (isset($_GET['productId'])and !empty($_GET['productId'])){

    $product->showProduct($_GET['productId']);

    if (isset($_POST['buy'])and $_POST['count']>0){
        $result = $_SESSION['user']->purchase($_GET['productId'],$_POST['count']);
        if ($result=='purchased'){

            echo '<script> alert(" Purchased succesfully. You will be redirected to your cart")</script>';
        header('Refresh: 0; url=index.php?page=bucket');

        } else {
            echo 'You try to purchase too many at once.';
        }

} else {  }


} else {
    echo '<h1 id="err">Please select some product</h1>';
}