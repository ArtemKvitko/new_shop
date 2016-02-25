<?php
if (isset($_GET['productId'])and !empty($_GET['productId'])){

    $product->showProduct($_GET['productId']);

} else {
    echo '<h1 id="err">Please select some product</h1>';
}