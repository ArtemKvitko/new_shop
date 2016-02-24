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
        case 2:
            echo "i равно 2";
            break;
    }



}





?>

</div>



</body>
</html>
