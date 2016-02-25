<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="utf-8" />
</head>
<body>

<?php
session_start();

function __autoload($class){
    require_once 'class.'.$class.'.inc.php';
}



echo '<div id="main"><div id="top">
<div id="logo"><a href="index.php"><img src="img/logo.png" id="logotip" ></a> </div>
';
require_once 'authorizationForm.php';
echo '</div>';

echo '   <div id="navigation"> ';

        $db = new Db();

$product = new Products();
$b= $product->getCategories();


foreach($b as $category){
    echo '<p><a href="index.php?page=products&category='.$category->id.'">'.$category->name.'</a>';
}


 echo '   </div> ';

if (isset($_GET['page'])) {

    switch ($_GET['page']) {
        case 'regUser':
            require_once('registrationForm.php');
            break;
        case 'logOut':
            session_destroy();
            header('Refresh: 0; url=index.php');
            break;
        case 'products':
            if (isset($_GET['category'])){
                $prod = $product->getProducts($_GET['category']);
                $product->printProducts($prod);
            }
            break;
        case 'product':
            require_once('productForm.php');
            break;
    }


}



?>




</div>




</body>
</html>
