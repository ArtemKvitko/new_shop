<div id="authForm">
<?php

if(!isset($_SESSION['user'])) {
    echo '
<form method="post" id="nouser">
<label>e - mail: &nbsp;  </label> <input name="email" type="text" ><br>
<label>Password</label> <input name="password" type="password" ><br>
<input name="login" type="submit" value="LogIn" id="logins"> or <a href="index.php?page=regUser"> Sing Up </a>
</form> ';


if ($_POST['login']) {
    $check=Db::userExist($_POST['email']);

        if ($check) {

            echo 'YoooHoo';
        } else {echo 'Problem';}
}


} else {
    if (!isset($bucket)){
        $bkimg='empty.png';
    } else {
        $bkimg='full.png';
    }

    Echo "
    <form id='reguser'>Hello, <a href='index.php?page=userInfo'>".$_SESSION['user']->name." ".$_SESSION['user']->sname."</a>
    <a href='index.php?page=logOut' ><img src='img/logout.png' height='16px' alt='log Out' ></a></form>
    ";

    echo '
    <a href = index.php?page=bucket><img src = "img/'.$bkimg.'" id="bucket"></a>
    ';


}



?>

</div>
