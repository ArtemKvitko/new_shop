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


?>





</body>
</html>
