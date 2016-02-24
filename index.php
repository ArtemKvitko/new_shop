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

$db = new Db();
$db ->userExist('mymail');

require_once 'authorizationForm.php';
var_dump($_GET);

if ($_GET['page']='regUser') {
    require_once('registrationForm.php');
}


?>





</body>
</html>
