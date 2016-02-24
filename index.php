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




require_once 'authorizationForm.php';


if (isset($_GET['page'])) {
    if ($_GET['page']=='regUser'){

       require_once('registrationForm.php');
    }

    if ($_GET['page']=='logOut'){
        session_destroy();
        header('Refresh: 0; url=index.php');

    }
}





?>





</body>
</html>
