<?php

if (isset($_GET['productId']) and !empty($_GET['productId'])) {
    $product->showProduct($_GET['productId']);

    if (isset($_POST['buy']) and $_POST['count'] > 0) {
        $result = isset($_SESSION['user']) ? $_SESSION['user']->purchase($_GET['productId'], $_POST['count']) : 'Please relogin!' ;
        if ($result == 'purchased') {

            echo '<script> alert(" Purchased succesfully. \n You will be redirected to your cart")</script>';
            header('Refresh: 0; url=index.php?page=bucket');

        } else {

         echo $result=='Please relogin!' ? '<script> alert("Please relogin!")</script>' :
            '<script> alert("You\'ve tryed to purchase too many products than is available.")</script>';

        }

    } else {
    }


} else {
    echo '<br><h1 id="err">Please select some product</h1>';
}