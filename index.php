<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8"/>
</head>
<body>

<?php
session_start();

function __autoload($class)
{
    require_once 'class.' . $class . '.inc.php';
}

echo '<div id="main">
<div id="top">
    <div id="logo">
        <a href="index.php"><img src="img/logo.png" id="logotip" ></a>
    </div>
';

require_once 'authorizationForm.php';
echo '</div>';
echo '<div id="Block">';


echo '   <div id="navigation"> ';

$db = new Db();
$product = new Products();
$b = $product->getCategories();

echo '<div id="button">
<ul>';

foreach ($b as $category) {
    echo '<li><a href="index.php?page=products&category=' . $category->id . '">' . $category->category_name . '</a></li>';
}
echo '</ul>
</div>';


echo '   </div> ';

echo "<div id='pageBlock'>";

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


if (isset($_GET['page'])) {

    switch ($_GET['page']) {
        case 'regUser':
            require_once('registrationForm.php');
            break;
        case 'search':
            if (!empty($_POST['search'])) {
                echo '<h1>Search results</h1>';
                $product->doSearch($_POST['search']);
            }


            break;
        case 'logOut':
            session_destroy();
            header('Refresh: 0; url=index.php');
            break;
        case 'purchaseHistory':
            isset($_SESSION['user']) ? $_SESSION['user']->purchaseHistory() : null;

            break;
        case 'products':
            echo '<div id="order"> Order by:
        <a href="index.php?page=products&category=' . $_GET["category"] . '&orderBy=brand"> BRAND </a>
        or
        <a href="index.php?page=products&category=' . $_GET["category"] . '&orderBy=price"> PRICE </a>  </div>';

            if (isset($_GET['category'])) {
                $prod = $product->getProducts($_GET['category'], (isset($_GET['orderBy'])) ? $_GET['orderBy'] : null);
                $product->printProducts($prod);
            }
            break;
        case 'product':
            require_once('productForm.php');
            break;

        case 'bucket':
            require_once('bucketForm.php');
            break;
        case 'userInfo':
            if (isset($_SESSION['user'])) {
                $_SESSION['user']->userInfo();
            }
            break;
    }


} else {
    echo '<<== Please select one of categories';
}
echo '</div>';
echo '<div id="clr"></div></div>';


?>


</div>


</body>
</html>
